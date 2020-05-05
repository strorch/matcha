import { take, fork, put } from 'redux-saga/effects';
import { baseURL } from 'config/api';
import * as types from 'actions/types';
import { RequestTypes } from 'models/request';
import { actionDone, actionFail } from 'helpers';

const formRequestInit = (method: RequestTypes, payload): RequestInit => {
  const { headers, params } = payload;

  return method === RequestTypes.Get
    ? { method, headers }
    : { method, headers, body: JSON.stringify(params) };
};

// const formFileRequestInit = (payload): RequestInit => {
//   const { headers, formData } = payload;

//   headers.delete('Content-Type'); // Let the browser set it
//   return { method: RequestMethod.Post, headers, body: formData };
// };

// const formGetRequestUrl = (base: string, params: object) =>
//   Object.keys(params).reduce((acc, cur, i) => {
//     const delimiter = !i ? '?' : '&';
//     const isValueDefined = params[cur] !== undefined && params[cur] !== null;
//     const query = isValueDefined ? delimiter + cur + '=' + params[cur] : '';

//     return `${acc + query}`;
//   }, base);

const formRequestHeaders = () => {
  const headers = new Headers();
  headers.set('Content-Type', 'application/json');

  return headers;
};

function* callHandleHttpRequest(payload) {
  // Be careful! All params will be transferred into url for GET request
  const { type: actionType, endpoint, method, data } = payload;

  // Additional logic for creating get request with search parameters if present
  const urlEndpointBase = `${baseURL}${endpoint}`;
  const url = urlEndpointBase;
  // const url =
  //   method === RequestTypes.Get && !isEmpty(params)
  //     ? formGetRequestUrl(urlEndpointBase, params)
  //     : urlEndpointBase;

  const headers = formRequestHeaders();

  const request = new Request(
    url,
    formRequestInit(method, { headers, data })
    // uid.isFile
    //   ? formFileRequestInit({ headers, formData })
    //   : formRequestInit(method, { headers, params })
  );

  try {
    const resObj = yield fetch(request);
    const response = yield resObj.json();
    yield put({ type: types.MAKE_HTTP_REQUEST_DONE, payload: response });

      const isError = !!response.error;
      const type = !isError
        ? actionDone(actionType)
        : actionFail(actionType);

      yield put({
        type,
        ok: response.ok,
        error: isError ? response.error : null,
        payload: !isError ? response.data : null
      });
  } catch (error) {
    yield put({ type: types.MAKE_HTTP_REQUEST_FAIL, error });
  }
}

export default function* httpSaga() {
  while (true) {
    const { payload } = yield take(types.MAKE_HTTP_REQUEST);
    yield fork(callHandleHttpRequest, payload);
  }
}
