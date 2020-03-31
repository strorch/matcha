import { put, takeLatest, delay } from 'redux-saga/effects';
import * as types from 'actions/types';
import { GeneralRoutes } from 'routes';
import { IMessagePageLocationState } from 'components/MessagePage';

function* callSignIn(action) {
  console.log('SignIn: ', action);

  yield delay(1000);

  yield put({
    type: types.SIGN_IN_DONE,
    payload: {
      first_name: 'Alex',
      last_name: 'Smith',
      username: 'alexsmith',
      email: 'alexsmith@email.com'
    }
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

export default function* auth() {
  yield takeLatest(types.SIGN_IN, callSignIn);
  yield takeLatest(types.SIGN_UP, callSignUp);
};
