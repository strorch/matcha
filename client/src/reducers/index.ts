import { combineReducers, Reducer } from "redux";
import * as types from 'actions/types';
import { SocketConnectionStatus, IGeneralState } from "models";

const initState: IGeneralState = {
  socketStatus: SocketConnectionStatus.Off,
  user: {
    isAuthenticated: false,
    isFetching: false,
    data: null,
    error: null
  }
}

const GeneralReducer: Reducer<IGeneralState> = (state = initState, action) => {
  switch (action.type) {
    case types.WS_STATUS_ON:
      return { ...state, socketStatus: SocketConnectionStatus.On };
    case types.WS_STATUS_OFF:
      return { ...state, socketStatus: SocketConnectionStatus.Off };

    case types.SIGN_UP:
    case types.SIGN_IN:
      return {
        ...state,
        user: {
          ...state.user,
          isFetching: true
        }
      };
    case types.SIGN_UP_DONE:
      return {
        ...state,
        user: {
          ...state.user,
          isFetching: false
        }
      };
    case types.SIGN_IN_DONE:
      return {
        ...state,
        user: {
          ...state.user,
          isAuthenticated: true,
          isFetching: false,
          data: action.payload
        }
      };
    case types.SIGN_OUT:
      return {
        ...state,
        user: {
          ...state.user,
          isAuthenticated: false,
          isFetching: false,
          data: null,
          error: null
        }
      };
    default:
      return state;
  }
}

// FIXME: fix any
export default () =>
  combineReducers<IGeneralState & any /* Declare rest of reducers*/>({
    general: GeneralReducer
  });
