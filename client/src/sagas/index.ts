import { fork, all } from 'redux-saga/effects';
import socketSaga from './socket';
import httpSaga from './http';
import chat from './chat';
import auth from './auth';
import users from './users';
import formData from './formData';

const combinedSagas = [socketSaga, httpSaga, auth, chat, users, formData];

export default function* rootSaga() {
  yield all(combinedSagas.map(fork))
};
