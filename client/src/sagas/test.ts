import { put, takeEvery } from 'redux-saga/effects';
import * as types from 'actions/types';

function* callSendTestChatMessage(action) {
  try {
    console.log(action);
    yield put({
      type: types.SEND_TEST_CHAT_MESSAGE_DONE
    })
  } catch (error) {
    yield put({
      type: types.SEND_TEST_CHAT_MESSAGE_FAIL,
      error
    })
  }
}

export default function* test() {
  yield takeEvery(types.SEND_TEST_CHAT_MESSAGE, callSendTestChatMessage);
}
