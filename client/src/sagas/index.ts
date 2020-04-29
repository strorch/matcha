import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';
import chat from './chat';
import auth from './auth';
import users from './users';
import formData from './formData';

const combinedSagas = [socketSaga, auth, chat, users, formData];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
