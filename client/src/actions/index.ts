import * as types from './types';
import { ISignUpFormValues } from 'containers/SignUp';
import { ISignInFormValues } from 'containers/SignIn';

export const Actions = {

  // Sockets -->
  wsChannelStart: () => ({ type: types.WS_CHANNEL_START }),
  wsChannelStop: () => ({ type: types.WS_CHANNEL_STOP }),
  wsStatusOn: () => ({ type: types.WS_STATUS_ON }),
  wsStatusOff: () => ({ type: types.WS_STATUS_OFF }),

  sendMessage: <T extends object>(payload) => ({ type: types.SEND_MESSAGE, payload }),
  // <-- End of Sockets

  // Auth -->
  signUp: (payload: ISignUpFormValues) => ({type: types.SIGN_UP, payload }),
  signIn: (payload: ISignInFormValues) => ({ type: types.SIGN_IN, payload }),
  signOut: () => ({ type: types.SIGN_OUT }),
  // <-- End of Auth

  sendChatMessage: (sender_id: string, receiver_id: string, message: string) => ({ type: types.SEND_CHAT_MESSAGE, payload: { sender_id, receiver_id, message } })
};
