import { Reducer } from "redux";
import { IFormDataState } from "models";
import * as types from 'actions/types';

const initState: IFormDataState = {
  interests: {
    isFetching: false,
    data: null,
    error: null
  }
};

const formDataReducer: Reducer<IFormDataState> = (state = initState, action) => {
  switch (action.type) {
    case types.GET_INTERESTS_LIST:
      return {
        ...state,
        interests: {
          ...state.interests,
          isFetching: true
        }
      };
    case types.GET_INTERESTS_LIST_DONE:
      return {
        ...state,
        interests: {
          ...state.interests,
          isFetching: false,
          data: action.payload
        }
      };
    default:
      return state;
  }
};

export default formDataReducer;
