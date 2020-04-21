import * as React from 'react';
import { Link } from 'react-router-dom';
import { Segment, Button, Header } from 'semantic-ui-react';
import Greetings from './Greetings';
import { GeneralRoutes } from 'routes';

const MainOption1 = () => (
  <Segment vertical padded textAlign="center">
    <Greetings />
    <Header as="h2" style={{ fontFamily: 'Leckerli One' }}>Let's, </Header>
    <Button.Group>
      <Link to={GeneralRoutes.SignUp}>
        <Button size="big" primary>Sign Up</Button>
      </Link>
      <Button.Or />
      <Link to={GeneralRoutes.SignIn}>
        <Button size="big">Sign In</Button>
      </Link>
    </Button.Group>
  </Segment>
);

export default MainOption1;
