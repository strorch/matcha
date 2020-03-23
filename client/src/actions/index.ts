import * as types from 'actions/types';

export const Actions = {

  // Sockets -->
  wsChannelStart: () => ({ type: types.WS_CHANNEL_START }),
  wsChannelStop: () => ({ type: types.WS_CHANNEL_STOP }),
  wsStatusOn: () => ({ type: types.WS_STATUS_ON }),
  wsStatusOff: () => ({ type: types.WS_STATUS_OFF }),

  sendMessage: <T extends object>(payload) => ({ type: types.SEND_MESSAGE, payload }),
  // <-- End of Sockets

  sendChatMessage: (sender_id: string, receiver_id: string, message: string) => ({ type: types.SEND_CHAT_MESSAGE, payload: { sender_id, receiver_id, message } })

};
