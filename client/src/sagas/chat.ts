import { put, takeEvery } from 'redux-saga/effects';
import * as types from 'actions/types';

function* callSendChatMessage(action) {
  try {
    console.log(action);
    yield put({
      type: types.SEND_CHAT_MESSAGE_DONE
    })
  } catch (error) {
    yield put({
      type: types.SEND_CHAT_MESSAGE_FAIL,
      error
    })
  }
}

export default function* chat() {
  yield takeEvery(types.SEND_CHAT_MESSAGE, callSendChatMessage);
}
