import * as React from 'react';
import { Button, Form, Icon, Message, Grid } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';

interface ISignUpForm {
  temp?: string;
}

const SignUpForm = (props: ISignUpForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Message
        attached
        header='Welcome to Matcha!'
      />
      <Form className='attached fluid segment'>
        <Form.Input
          fluid
          label='First Name'
          placeholder='First Name'
          type='text'
        />
        <Form.Input
          fluid
          label='Last Name'
          placeholder='Last Name'
          type='text'
        />
        <Form.Input
          fluid
          label='Username'
          placeholder='Username'
          type='text'
        />
        <Form.Input
          fluid
          label="Password"
          placeholder="Password"
          type="password"
        />
        <Form.Input
          fluid
          label="Confirm Password"
          placeholder="Password"
          type="password"
        />
        <Button color='blue' fluid>
          Sign Up
        </Button>
      </Form>
      <Message attached='bottom' warning>
        <Icon name='help' />
        Already signed up?&nbsp;<a href={GeneralRoutes.SignIn}>Sign In</a>&nbsp;instead.
      </Message>
    </Grid.Column>
  </Grid>
);

export default SignUpForm;
