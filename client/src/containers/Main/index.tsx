import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Actions } from 'actions';
import logo from 'assets/logo.svg';

import './styles.css';  // FIXME: remove custom styles

interface IMainProps {
  actions: typeof Actions;
}

const Main = ({ actions }: IMainProps) => {
  useEffect(() => {
    actions.wsChannelStart();
  }, [actions]);
  
  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} className="App-logo" alt="logo" />
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
