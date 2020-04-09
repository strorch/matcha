import { Reducer } from "redux";
import { IFormData } from "models";

const initState: IFormData = {
  interests: {
    isFetching: false,
    data: null,
    error: null
  }
};

const formDataReducer: Reducer<IFormData> = (state = initState, action) => {
  switch (action.type) {
    default:
      return state;
  }
};

export default formDataReducer;
