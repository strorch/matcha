import { put, takeEvery } from 'redux-saga/effects';
import * as types from 'actions/types';
import { Actions } from 'actions';

function* callSendChatMessage(action) {
  try {
    yield put(Actions.sendMessage(action));
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
