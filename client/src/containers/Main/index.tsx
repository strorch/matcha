import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { Link } from "react-router-dom";
import { Button } from 'semantic-ui-react';
import { bindActionCreators } from 'redux';
import { Actions } from 'actions';
import logo from 'assets/logo.svg';
import { GeneralRoutes } from 'routes';

import './styles.css';  // FIXME: remove custom styles

interface IMainProps {
  actions: typeof Actions;
}

const Main = ({ actions }: IMainProps) => {
  useEffect(() => {
    actions.wsChannelStart();
    actions.sendMessage({test: 'test'});
  }, [actions]);
  
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
        <Link to={GeneralRoutes.Chat}>
          <Button>Chat</Button>
        </Link>
        <Link to={GeneralRoutes.SignIn}>
          <Button>Sign in</Button>
        </Link>
        <Link to={GeneralRoutes.SignUp}>
          <Button>Sign up</Button>
        </Link>
      </header>
    </div>
  );
};

const mapStateToProps = state => state;
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Main);
