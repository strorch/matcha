import { put, takeLatest, delay } from 'redux-saga/effects';
import * as types from 'actions/types';

const INTERESTS_LIST_MOCK = [
  {
    id: 0,
    title: '#vegan'
  },
  {
    id: 1,
    title: '#geek'
  },
  {
    id: 2,
    title: '#piercing'
  }
];

function* callGetInterestsList() {
  console.log('callGetInterestsList');

  yield delay(1000);
  yield put({
    type: types.FETCH_INTERESTS_LIST_DONE,
    payload: INTERESTS_LIST_MOCK
  });
}

export default function* formData() {
  yield takeLatest(types.FETCH_INTERESTS_LIST, callGetInterestsList);
}
