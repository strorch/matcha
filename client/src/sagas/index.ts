import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';
import chat from './chat';
import auth from './auth';

const combinedSagas = [socketSaga, auth, chat];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
