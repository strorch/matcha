import * as React from 'react';
import { Link } from 'react-router-dom';
import { Button } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';

const Chat = () => (
  <>
    <h1>Chat!</h1>
    <Link to={GeneralRoutes.Main}>
      <Button>Main</Button>
    </Link>
  </>
);

export default Chat;
