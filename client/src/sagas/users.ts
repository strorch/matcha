import { put, takeLatest, delay } from 'redux-saga/effects';
import * as types from 'actions/types';

function* callFetchUserProfile(action) {
  console.log('callFetchUserProfile');

  yield delay(1000);
  yield put({
    type: types.FETCH_USER_PROFILE_DONE,
    payload: {
      id: action.payload.id,
    },
  });
}

function* callUpdateUserProfile(action) {
  console.log('callUpdateUserProfile');
}

export default function* users() {
  yield takeLatest(types.FETCH_USER_PROFILE, callFetchUserProfile);
  yield takeLatest(types.UPDATE_USER_PROFILE, callUpdateUserProfile);
}
