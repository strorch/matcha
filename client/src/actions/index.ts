import { History } from 'history';
import * as types from './types';
import { ISignUpFormValues } from 'containers/SignUp';
import { ISignInFormValues } from 'containers/SignIn';
import { IUser } from 'models';

export const Actions = {

  // Sockets -->
  wsChannelStart: () => ({ type: types.WS_CHANNEL_START }),
  wsChannelStop: () => ({ type: types.WS_CHANNEL_STOP }),
  wsStatusOn: () => ({ type: types.WS_STATUS_ON }),
  wsStatusOff: () => ({ type: types.WS_STATUS_OFF }),

  sendMessage: <T extends object>(payload) => ({ type: types.SEND_MESSAGE, payload }),
  // <-- End of Sockets

  // Auth -->
  signUp: (payload: ISignUpFormValues, history: History) => ({ type: types.SIGN_UP, payload: { ...payload, history } }),
  signIn: (payload: ISignInFormValues, history: History) => ({ type: types.SIGN_IN, payload: { ...payload, history } }),
  signOut: () => ({ type: types.SIGN_OUT }),

  checkForSignedInUser: () => ({ type: types.CHECK_FOR_SIGNED_IN_USER }),
  // <-- End of Auth

  // Chat -->
  sendChatMessage: (sender_id: string, receiver_id: string, message: string) => ({ type: types.SEND_CHAT_MESSAGE, payload: { sender_id, receiver_id, message } }),
  // <-- End of Chat

  // Users -->
  fetchUserProfile: (id: number) => ({ type: types.FETCH_USER_PROFILE, payload: { id } }),
  setCurrentUserProfile: (user: IUser) => ({ type: types.SET_CURRENT_PROFILE, payload: user }),
  clearCurrentProfile: () => ({ type: types.CLEAR_CURRENT_PROFILE }),
  // <-- End of Users

  // Form data -->
  fetchInterestsList: () => ({ type: types.FETCH_INTERESTS_LIST })
  // <-- End of Form data
};
