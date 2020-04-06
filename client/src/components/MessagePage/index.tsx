import * as React from 'react';
import { RouteComponentProps } from 'react-router';
import { Message, Segment, Button, Header } from 'semantic-ui-react';
import { Link } from 'react-router-dom';
import { GeneralRoutes } from 'routes';

export interface IMessagePageLocationState {
  icon?: string;
  header: string;
  content: string;
  isSuccess: boolean;
}

type IMessagePageProps = RouteComponentProps<void, any, IMessagePageLocationState>;

const MessagePage = ({
  location
}: IMessagePageProps) => {
  if (!location.state) {
    return (
      <Segment textAlign='center' vertical padded>
        <Header as="h2">No messages for u ;(</Header>
      </Segment>
    );
  }
  
  const { isSuccess, ...messageProps } = location.state;

  return (
    <Segment vertical padded>
      <Message
        size="large"
        {...messageProps}
        success={isSuccess}
        negative={!isSuccess}
      />
      <Link to={GeneralRoutes.Main}>
        <Button
          color="blue"
        >
          to Main Page
        </Button>
      </Link>
    </Segment>
  );
}

export default MessagePage;
