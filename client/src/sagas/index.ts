import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';
import test from './test';

const combinedSagas = [socketSaga, test];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
