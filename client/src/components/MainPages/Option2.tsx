import * as React from 'react';
import { Link } from 'react-router-dom';
import { Segment, Button, Header } from 'semantic-ui-react';
import Greetings from './Greetings';
import { GeneralRoutes } from 'routes';

const MainOption2 = () => (
  <Segment vertical padded textAlign="center">
    <Greetings />
    <Header as="h2" style={{ fontFamily: 'Leckerli One' }}>Please, </Header>
    <Link to={GeneralRoutes.SetInitialInfo}>
      <Button size="big" primary>Set Initial Info</Button>
    </Link>
  </Segment>
);

export default MainOption2;
