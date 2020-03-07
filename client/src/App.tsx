import React from 'react';
import { Provider } from 'react-redux';
import { BrowserRouter } from 'react-router-dom';

import AppRouter from 'AppRouter';

import store from 'store/configureStore';

import './App.css';
import 'semantic-ui-css/semantic.min.css';

export default () => (
  <Provider store={store}>
    <BrowserRouter>
      <AppRouter />
    </BrowserRouter>
  </Provider>
);
