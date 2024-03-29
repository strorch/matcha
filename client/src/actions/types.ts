// Http -->
export const MAKE_HTTP_REQUEST = 'MAKE_HTTP_REQUEST';
export const MAKE_HTTP_REQUEST_DONE = 'MAKE_HTTP_REQUEST_DONE';
export const MAKE_HTTP_REQUEST_FAIL = 'MAKE_HTTP_REQUEST_FAIL';
// <-- End of Http

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
export const SIGN_UP_FAIL = 'SIGN_UP_FAIL';

export const SIGN_IN = 'SIGN_IN';
export const SIGN_IN_DONE = 'SIGN_IN_DONE';
// export const SIGN_IN_FAIL = 'SIGN_IN_FAIL';

export const SIGN_OUT = 'SIGN_OUT';
export const CLEAR_USER_ERROR = 'CLEAR_USER_ERROR';

export const CHECK_FOR_SIGNED_IN_USER = 'CHECK_FOR_SIGNED_IN_USER';
export const CHECK_FOR_SIGNED_IN_USER_DONE = 'CHECK_FOR_SIGNED_IN_USER_DONE';
// <-- End of Auth

// Chat -->
export const SEND_CHAT_MESSAGE = 'SEND_CHAT_MESSAGE';
export const SEND_CHAT_MESSAGE_DONE = 'SEND_CHAT_MESSAGE_DONE';
export const SEND_CHAT_MESSAGE_FAIL = 'SEND_CHAT_MESSAGE_FAIL';
// <-- End of Chat

// Users -->
export const FETCH_USER_PROFILE = 'FETCH_USER_PROFILE';
export const FETCH_USER_PROFILE_DONE = 'FETCH_USER_PROFILE_DONE';
// export const FETCH_USER_PROFILE_FAIL = 'FETCH_USER_PROFILE_FAIL';
export const SET_CURRENT_PROFILE = 'SET_CURRENT_PROFILE';
export const CLEAR_CURRENT_PROFILE = 'CLEAR_CURRENT_PROFILE';
export const UPDATE_USER_PROFILE = 'UPDATE_USER_PROFILE';
export const UPDATE_USER_IMAGES = 'UPDATE_USER_IMAGES';
// <-- End of Users

// Form data -->
export const FETCH_INTERESTS_LIST = 'FETCH_INTERESTS_LIST';
export const FETCH_INTERESTS_LIST_DONE = 'FETCH_INTERESTS_LIST_DONE';
// export const FETCH_INTERESTS_LIST_FAIL = 'FETCH_INTERESTS_LIST_FAIL';
export const ADD_NEW_INTEREST = 'ADD_NEW_INTEREST';
// <-- End of Form data
