export {};
// import { take, fork, put, call, delay } from 'redux-saga/effects';
// import * as types from 'actions/types';
// import isEmpty from 'lodash/isEmpty';
// import { RequestMethod } from 'models/enums';
// import { baseURL, kvApi } from 'api/config/baseUrl';
// import { getActiveUserFromLocalStorage } from 'services/localStorage';
// import { actionTransitional, actionDirectFail, actionDirectDone } from 'services/actionTypes';
// import { TOKEN_EXPIRED, TOKEN_INVALID } from 'config/errorCodes';
// import { removeFromSignedUser } from 'services/localStorage';
// import { getRequestConfig } from 'api/config/requestConfig';

// const formRequestInit = (method: RequestMethod, payload): RequestInit => {
//   const { headers, params } = payload;

//   return method === RequestMethod.Get
//     ? { method, headers }
//     : { method, headers, body: JSON.stringify(params) };
// };

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

// const formRequestHeaders = () => {
//   const headers = new Headers();
//   headers.set('Content-Type', 'application/json');

//   return headers;
// };

// function* callHandleHttpRequest(payload) {
//   // Be careful! All params will be transferred into url for GET request
//   const { endpoint, uid, method, formData, ...params } = payload;

//   // Additional logic for creating get request with parameters if present
//   const urlEndpointBase = `${baseURL}${endpoint}`;
//   const url =
//     method === RequestMethod.Get && !isEmpty(params)
//       ? formGetRequestUrl(urlEndpointBase, params)
//       : urlEndpointBase;

//   const headers = formRequestHeaders();

//   const request = new Request(
//     url,
//     uid.isFile
//       ? formFileRequestInit({ headers, formData })
//       : formRequestInit(method, { headers, params })
//   );

//   try {
//     const resObj = yield fetch(request);
//     const response = yield resObj.json();
//     yield put({ type: types.MAKE_HTTP_REQUEST_DONE, payload: response });

//     // Take 'data' field if exists or using the whole response object
//     const { data } = response;
//     const responseData = data || response;

//     if (uid && uid.type) {
//       const isError = !!responseData.error;
//       const type = uid.transitional
//         ? actionTransitional(uid.type)
//         : isError
//         ? actionDirectFail(uid.type)
//         : actionDirectDone(uid.type);

//       yield put({
//         type,
//         meta: uid,
//         ok: resObj.ok,
//         error: isError ? responseData : null,
//         payload: isError ? null : responseData
//       });
//     }
//   } catch (error) {
//     yield put({ type: types.MAKE_HTTP_REQUEST_FAIL, error });
//   }
// }

// export default function* httpSaga() {
//   while (true) {
//     const { payload } = yield take(types.MAKE_HTTP_REQUEST);
//     yield fork(callHandleHttpRequest, payload);
//   }
// }
