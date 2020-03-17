import { eventChannel, END } from 'redux-saga';
import {
  put,
  call,
  fork,
  take,
  cancel,
  cancelled,
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
    const onMessage = (event: MessageEvent) => emit(event.data);;

    socket.addEventListener('message', onMessage);

    socket.addEventListener('close', () => emit(END));

    return () => {
      socket.removeEventListener('message', onMessage);
      socket.close();
    };
  });

function* listenForMessages() {
  let socket;
  let socketChannel;
  
  try {
    socket        = yield call(createWebSocketConnection);
    socketChannel = yield call(createWebSocketChannel, socket);

    // tell the application that we have a connection
    yield put(Actions.wsStatusOn());

    yield fork(sendMessage, socket);

    while (true) {
      // wait for a message from the channel
      const payload = yield take(socketChannel);
      console.log('Received message: ', payload);
    }
  } catch (error) {
    console.error(`Error while connecting to the: ${socketURL}`);
  } finally {
    console.warn('WebSocket disconnected!');
    if (yield cancelled()) {
      socketChannel && socketChannel.close();
    }
    yield disconnect();
  }
}

function* disconnect() {
  yield put(Actions.wsStatusOff());
}

function* sendMessage(socket: WebSocket) {
  const sendMessageChannel = yield actionChannel(types.SEND_MESSAGE);
  while (true) {
    try {
      const { payload } = yield take(sendMessageChannel);
      const message = JSON.stringify({
        ...payload
      });

      yield socket.send(message);
      yield put({ type: types.SEND_MESSAGE_DONE });
    } catch (error) {
      yield put({ type: types.SEND_MESSAGE_FAIL });
    }
  }
}


export default function* socketSaga() {
  // starts the task in the background
  const socketTask = yield fork(listenForMessages);

  // when DISCONNECT action is dispatched, we cancel the socket task
  yield take(types.WS_CHANNEL_STOP);
  yield cancel(socketTask);
}
