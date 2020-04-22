import * as React from 'react';
import { Link } from 'react-router-dom';
import { Header, Segment, Button } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';

const NotFoundPage = () => (
  <Segment textAlign='center' vertical padded>
    <Header as="h2">404</Header>
    <Header as="h3">Page Not Found</Header>
    <Link to={GeneralRoutes.Main}>
        <Button
          color="blue"
        >
          to Main Page
        </Button>
      </Link>
  </Segment>
);

export default NotFoundPage;
