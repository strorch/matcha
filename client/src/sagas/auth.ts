import { put, call, takeLatest, delay } from 'redux-saga/effects';
import * as types from 'actions/types';
import { GeneralRoutes } from 'routes';
import { IUser } from 'models';
import { IMessagePageLocationState } from 'components/MessagePage';
import { setLocalStorageItem, removeLocalStorageItem, LocalStorageKeys, getLocalStorageItem } from 'services/localStorage';

function* callSignIn(action) {
  console.log('SignIn: ', action);

  yield delay(1000);

  const user = {
    first_name: 'Alex',
    last_name: 'Smith',
    username: 'alexsmith',
    email: 'alexsmith@email.com'
  };

  yield call(setLocalStorageItem, LocalStorageKeys.User, user as IUser);

  yield put({
    type: types.SIGN_IN_DONE,
    payload: user
  });
}

function* callSignUp(action) {
  console.log('SignUp: ', action);

  yield delay(1000);

  const { payload: { history, username, email } } = action;
  history.push(GeneralRoutes.Message, {
    isSuccess: true,
    icon: 'inbox',
    header: 'Signed up!',
    content: `You did it, ${username}! Confirmation email was sent to ${email}, follow the instructions to validate your account ;)`
  } as IMessagePageLocationState);

  yield put({ type: types.SIGN_UP_DONE });
}

function* callSignOut() {
  yield call(removeLocalStorageItem, LocalStorageKeys.User);
}

function* callCheckForSignedInUser() {
  const activeUser = yield call(getLocalStorageItem, LocalStorageKeys.User);

  yield put({
    type: types.SIGN_IN_DONE,
    payload: JSON.parse(activeUser)
  })
}

export default function* auth() {
  yield takeLatest(types.SIGN_UP, callSignUp);
  yield takeLatest(types.SIGN_IN, callSignIn);
  yield takeLatest(types.SIGN_OUT, callSignOut);
  yield takeLatest(types.CHECK_FOR_SIGNED_IN_USER, callCheckForSignedInUser);
};
