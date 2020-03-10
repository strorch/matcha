import * as types from 'actions/types';

export const Actions = {

// Sockets -->
socketChannelStart: () => ({ type: types.CHANNEL_START }),
socketChannelStop: () => ({ type: types.CHANNEL_STOP }),
socketConnectionOn: () => ({ type: types.CONNECTION_ON }),
socketConnectionOff: () => ({ type: types.CONNECTION_OFF }),

sendMessage: <T extends object>(payload) => ({ type: types.SEND_MESSAGE, payload })
// <-- End of Sockets

};
