import * as React from 'react';
import { Grid, Form, Button, Message, Icon } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';

interface ISignInForm {
  temp?: string;
}

const SignInForm = (props: ISignInForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Message
        attached
        header='Welcome to Matcha!'
      />
      <Form className='attached fluid segment'>
        <Form.Input
          fluid
          type='text'
          label="Username"
          placeholder="Username"
        />
        <Form.Input
          fluid
          label="Password"
          placeholder="Password"
          type="password"
        />
        <Button color="blue" fluid>
          Sign In
        </Button>
      </Form>
      <Message attached='bottom' warning>
        <Icon name='help' />
        Not registered yet?&nbsp;<a href={GeneralRoutes.SignUp}>Sign Up</a>&nbsp;instead.
      </Message>
    </Grid.Column>
  </Grid>
);

export default SignInForm;
