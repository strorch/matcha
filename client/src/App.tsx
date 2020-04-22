import React, { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Loader } from 'semantic-ui-react';

import AppRouter from 'AppRouter';
import { Actions } from 'actions';

import './styles.sass';
import 'semantic-ui-css/semantic.min.css';

// fonts
import './assets/fonts/LeckerliOne/LeckerliOne-Regular.ttf';

interface IApp {
  actions: typeof Actions;
  isLocalStorageChecking: boolean;
}

const App = ({ actions, isLocalStorageChecking }: IApp) => {
  useEffect(() => {
    // get user from localStorage if previously signed in
    actions.checkForSignedInUser();

    // start websocket channel
    // actions.wsChannelStart();
  }, [actions]);

  return (
    !isLocalStorageChecking
      ? <AppRouter />
      : <Loader size="huge" active />
  );
};

export default connect(
  state => ({
    isLocalStorageChecking: state.general.user.isLocalStorageChecking
  }),
  dispatch => ({
    actions: bindActionCreators(Actions, dispatch)
  })
)(App);
