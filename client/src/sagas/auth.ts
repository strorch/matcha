import { put, call, takeLatest, take, delay } from 'redux-saga/effects';
import * as types from 'actions/types';
import { GeneralRoutes, ApiRoutes } from 'routes';
import { IUser } from 'models';
import { IMessagePageLocationState } from 'components/MessagePage';
import {
  setLocalStorageItem,
  removeLocalStorageItem,
  LocalStorageKeys,
  getLocalStorageItem,
} from 'services/localStorageService';
import { Actions } from 'actions';
import { RequestTypes } from 'models/request';
import { actionDone } from 'helpers';
import { Gender } from 'models';
import defaultAvatar from 'assets/user.svg';

function* callSignIn(action) {
  console.log('SignIn: ', action);

  yield delay(1000);

  const {
    payload: { history, username },
  } = action;
  const user = {
    firstName: 'Alex',
    lastName: 'Smith',
    username,
    email: 'alexsmith@email.com',
    isConfirmed: true,
    gender: Gender.Male,
    sexualPref: Gender.Female,
    bio: 'Bio',
    interests: ['0', '1'],
    images: Array(5).fill(defaultAvatar),
  };

  if (!user) {
    //show failed message
    console.log(user);
  } else if (!user.isConfirmed) {
    history.push(GeneralRoutes.Message, {
      isSuccess: false,
      icon: 'exclamation circle',
      header: 'Not Signed In!',
      content: `You have to confirm your email first! Confirmation email was sent to ${user.email}, follow the instructions to validate your account..`,
    } as IMessagePageLocationState);
  } else {
    yield call(setLocalStorageItem, LocalStorageKeys.User, user as IUser);

    yield put({
      type: types.SIGN_IN_DONE,
      payload: user,
    });
  }
}

function* callSignUp(action) {
  const {
    type,
    payload: { username, email, lastName, firstName, password, history },
  } = action;

  yield put(
    Actions.makeHttpRequest({
      type,
      endpoint: ApiRoutes.SignUp,
      method: RequestTypes.Post,
      data: {
        user: { username, email, lastName, firstName, password },
      },
    })
  );

  const response = yield take(actionDone(type));
  if (response.ok) {
    history.push(GeneralRoutes.Message, {
      isSuccess: true,
      icon: 'inbox',
      header: 'Signed Up!',
      content: `You did it, ${username}! Confirmation email was sent to ${email}, follow the instructions to validate your account ;)`,
    } as IMessagePageLocationState);
  }
}

function* callSignOut() {
  yield call(removeLocalStorageItem, LocalStorageKeys.User);
}

function* callCheckForSignedInUser() {
  const activeUser = yield call(getLocalStorageItem, LocalStorageKeys.User);

  if (activeUser) {
    yield put({
      type: types.SIGN_IN_DONE,
      payload: JSON.parse(activeUser),
    });
  }

  yield put({
    type: types.CHECK_FOR_SIGNED_IN_USER_DONE,
  });
}

export default function* auth() {
  yield takeLatest(types.SIGN_UP, callSignUp);
  yield takeLatest(types.SIGN_IN, callSignIn);
  yield takeLatest(types.SIGN_OUT, callSignOut);
  yield takeLatest(types.CHECK_FOR_SIGNED_IN_USER, callCheckForSignedInUser);
}
