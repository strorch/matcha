import { put, takeLatest, delay } from 'redux-saga/effects';
import * as types from 'actions/types';

function* callSignIn(action) {
  console.log('SignIn: ', action);

  yield delay(1000);

  yield put({
    type: types.SIGN_IN_DONE,
    payload: {
      first_name: 'Alex',
      last_name: 'Smith',
      username: 'alexsmith',
      email: 'alexsmith@email.com'
    }
  });
}

function* callSignUp(action) {
  console.log('SignUp: ', action);

  yield delay(1000);

  yield put({
    type: types.SIGN_UP_DONE,
    payload: {
      username: 'alexsmith',
      email: 'alexsmith@email.com'
    }
  });
}

export default function* auth() {
  yield takeLatest(types.SIGN_IN, callSignIn);
  yield takeLatest(types.SIGN_UP, callSignUp);
};
