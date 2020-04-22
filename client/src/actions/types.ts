// Sockets -->
const ws = 'WS_';
export const WS_STATUS_ON = `${ws}STATUS_ON`;
export const WS_STATUS_OFF = `${ws}STATUS_OFF`;
export const WS_CHANNEL_START = `${ws}CHANNEL_START`;
export const WS_CHANNEL_STOP = `${ws}CHANNEL_STOP`;

export const SEND_MESSAGE = `${ws}SEND_MESSAGE`;
export const SEND_MESSAGE_DONE = `${ws}SEND_MESSAGE_DONE`;
export const SEND_MESSAGE_FAIL = `${ws}SEND_MESSAGE_FAIL`;
// <-- End of Sockets

// Auth -->
export const SIGN_UP = 'SIGN_UP';
export const SIGN_UP_DONE = 'SIGN_UP_DONE';
// export const SIGN_UP_FAIL = 'SIGN_UP_FAIL';

export const SIGN_IN = 'SIGN_IN';
export const SIGN_IN_DONE = 'SIGN_IN_DONE';
// export const SIGN_IN_FAIL = 'SIGN_IN_FAIL';

export const SIGN_OUT = 'SIGN_OUT';

export const CHECK_FOR_SIGNED_IN_USER = 'CHECK_FOR_SIGNED_IN_USER';
export const CHECK_FOR_SIGNED_IN_USER_DONE = 'CHECK_FOR_SIGNED_IN_USER_DONE';
// <-- End of Auth

// Chat -->
export const SEND_CHAT_MESSAGE = 'SEND_CHAT_MESSAGE';
export const SEND_CHAT_MESSAGE_DONE = 'SEND_CHAT_MESSAGE_DONE';
export const SEND_CHAT_MESSAGE_FAIL = 'SEND_CHAT_MESSAGE_FAIL';
// <-- End of Chat

// Users -->
export const SET_CURRENT_PROFILE = 'SET_CURRENT_PROFILE';
export const CLEAR_CURRENT_PROFILE = 'CLEAR_CURRENT_PROFILE';
// <-- End of Users

// Form data -->
export const GET_INTERESTS_LIST = 'GET_INTERESTS_LIST';
export const GET_INTERESTS_LIST_DONE = 'GET_INTERESTS_LIST_DONE';
// export const GET_INTERESTS_LIST_FAIL = 'GET_INTERESTS_LIST_FAIL';
// <-- End of Form data
