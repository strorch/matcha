import { combineReducers, Reducer } from "redux";
import { SocketConnectionStatus, IGeneralState } from "models";
import * as types from 'actions/types';

const initState: IGeneralState = {
  socketStatus: SocketConnectionStatus.Off
}

const GeneralReducer: Reducer<IGeneralState> = (state = initState, action) => {
  switch (action.type) {
    case types.WS_STATUS_ON:
      return { ...state, socketStatus: SocketConnectionStatus.On };
    case types.WS_STATUS_OFF:
      return { ...state, socketStatus: SocketConnectionStatus.Off };
    default:
      return state;
  }
}

// FIXME: fix any
export default () =>
  combineReducers<IGeneralState & any /* Declare rest of reducers*/>({
    general: GeneralReducer
  });
