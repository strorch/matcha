import React, { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';

import AppRouter from 'AppRouter';
import { Actions } from 'actions';

import './styles.sass';
import 'semantic-ui-css/semantic.min.css';

interface IApp {
  actions: typeof Actions;
}

const App = ({ actions }: IApp) => {
  useEffect(() => {
    // get user from localStorage if previously signed in
    actions.checkForSignedInUser();

    // start websocket channel
    actions.wsChannelStart();
  }, [actions]);
  
  return <AppRouter />;
};

export default connect(
  null,
  dispatch => ({
    actions: bindActionCreators(Actions, dispatch)
  })
)(App);
