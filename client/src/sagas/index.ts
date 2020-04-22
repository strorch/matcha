import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';
import chat from './chat';
import auth from './auth';
import formData from './formData';

const combinedSagas = [socketSaga, auth, chat, formData];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
