import { Reducer } from 'redux';
import * as types from 'actions/types';
import { IUsersState } from 'models';
import { initReducer } from 'models';

const initState: IUsersState = {
  currentProfile: initReducer,
};

const usersReducer: Reducer<IUsersState> = (state = initState, action) => {
  switch (action.type) {
    case types.FETCH_USER_PROFILE:
      return {
        ...state,
        currentProfile: {
          ...state.currentProfile,
          isFetching: true,
        },
      };
    case types.FETCH_USER_PROFILE_DONE:
      return {
        ...state,
        currentProfile: {
          ...state.currentProfile,
          isFetching: false,
          data: action.payload, // the field is also can be set by SET_CURRENT_PROFILE
        },
      };

    case types.SET_CURRENT_PROFILE:
      return {
        ...state,
        currentProfile: {
          ...state.currentProfile,
          data: action.payload, // the field is also can be set by FETCH_USER_PROFILE_DONE
        },
      };
    case types.CLEAR_CURRENT_PROFILE:
      return {
        ...state,
        currentProfile: initReducer,
      };
    case types.UPDATE_USER_PROFILE: {
      return state;
    }
    default:
      return state;
  }
};

export default usersReducer;
