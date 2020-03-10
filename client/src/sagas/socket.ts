import { eventChannel, END } from 'redux-saga';
import {
  put,
  call,
  fork,
  take,
  actionChannel
} from 'redux-saga/effects';
import { Actions } from 'actions';
import * as types from 'actions/types'
import { socketURL } from 'config/api';

const createWebSocketConnection = () =>
  new Promise((resolve, reject) => {
    const socket = new WebSocket(socketURL);

    socket.addEventListener('open', () => resolve(socket));

    socket.addEventListener('error', reject);
  });

const createWebSocketChannel = (socket: WebSocket) =>
  eventChannel(emit => {
    const onMessage = (event: MessageEvent) => {
      console.log('onMessage: ', event);
      emit(event.data);
    };

    socket.addEventListener('message', onMessage);

    socket.addEventListener('close', () => emit(END));

    return () => {
      socket.removeEventListener('message', onMessage);
      socket.close();
    };
  });

function* listenForMessages(socket: WebSocket) {
  const socketChannel = yield call(createWebSocketChannel, socket);
  while (true) {

    // tell the application that we have a connection
    yield put(Actions.socketConnectionOn());

  }
}

function* sendMessage(socket: WebSocket) {
  const sendMessageChannel = yield actionChannel(types.SEND_MESSAGE);
  while (true) {
    try {
      const temp = yield take(sendMessageChannel);

      console.log('sendMessage: ', temp);

      yield put({ type: types.SEND_MESSAGE_DONE });
    } catch (error) {
      yield put({ type: types.SEND_MESSAGE_FAIL });
    }
  }
}

export default function* socketSaga() {
  yield take(types.CHANNEL_START);
  const socket = yield call(createWebSocketConnection);
  yield fork(listenForMessages, socket);
  yield fork(sendMessage, socket);
}
