import createSagaMiddleware from 'redux-saga';
import { createStore, applyMiddleware } from 'redux';
import { composeWithDevTools } from 'redux-devtools-extension';
import createRootReducer from 'reducers';
import rootSaga from 'sagas';

const isDev = process.env.NODE_ENV === 'development';

const sagaMiddleware = createSagaMiddleware();

const middleware = [sagaMiddleware];

const configureStore = () => {
  const store = createStore(
    createRootReducer(),
    isDev ? composeWithDevTools(applyMiddleware(...middleware)) : applyMiddleware(...middleware)
  );
  sagaMiddleware.run(rootSaga);
  return store;
};

const Store = configureStore();
export default Store;
