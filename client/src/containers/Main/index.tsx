import * as React from 'react';
import { Link } from "react-router-dom";
import { Button } from 'semantic-ui-react';
import logo from 'assets/logo.svg';
import { GeneralRoutes } from 'routes';

import './styles.css';  // FIXME: remove custom styles

const Main = () => (
  <div className="App">
    <header className="App-header">
      <img src={logo} className="App-logo" alt="logo" />
      <Link to={GeneralRoutes.Chat}>
        <Button>Chat</Button>
      </Link>
    </header>
  </div>
);

export default Main;
