import * as React from 'react';
import { Link } from 'react-router-dom';
import { Button } from 'semantic-ui-react';

const Chat = () => (
  <>
    <h1>Chat!</h1>
    <Link to="/">
      <Button>Main</Button>
    </Link>
  </>
);

export default Chat;
