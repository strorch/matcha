import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';
import chat from './chat';

const combinedSagas = [socketSaga, chat];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
