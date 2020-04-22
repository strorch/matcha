import { Reducer } from "redux";
import * as types from 'actions/types';
import { IUsersState } from "models";
import { initReducer } from "models";

const initState: IUsersState = {
  currentProfile: initReducer
}

const usersReducer: Reducer<IUsersState> = (state = initState, action) => {
  switch (action.type) {
    case types.SET_CURRENT_PROFILE:
      return {
        ...state,
        currentProfile: {
          ...state.currentProfile,
          data: action.payload
        }
      };
    case types.CLEAR_CURRENT_PROFILE:
      return {
        ...state,
        currentProfile: initReducer
      };
    default:
      return state;
  }
}

export default usersReducer;
