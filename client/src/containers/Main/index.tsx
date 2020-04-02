import * as React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Actions } from 'actions';
import logo from 'assets/logo.svg';

import './styles.css';  // FIXME: remove custom styles

interface IMainProps {
  temp?: string;
}

const Main = ({ temp }: IMainProps) => {  
  return (
      <div style={{ height: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center' }}>
        <img src={logo} className="App-logo" alt="logo" />
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
