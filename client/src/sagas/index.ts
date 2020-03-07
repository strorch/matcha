import { fork, all } from 'redux-saga/effects';

const combinedSagas = [];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
