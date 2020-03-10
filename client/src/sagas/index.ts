import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';

const combinedSagas = [socketSaga];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
