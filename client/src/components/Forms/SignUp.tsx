import * as React from 'react';
import { Button, Form, Icon, Message } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';

interface ISignUpForm {
  temp?: string;
}

const SignUpForm = (props: ISignUpForm) => (
  <>
    <Message
      attached
      header='Welcome to Matcha!'
      content='Fill out the form below to sign up for a new account.'
    />
    <Form className='attached fluid segment'>
      <Form.Group widths='equal'>
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
      </Form.Group>
      <Form.Input label='Username' placeholder='Username' type='text' />
      <Form.Input label='Password' type='password' />
      <Button color='blue'>Submit</Button>
    </Form>
    <Message attached='bottom' warning>
      <Icon name='help' />
      Already signed up?&nbsp;<a href={GeneralRoutes.SignIn}>Sign in</a>&nbsp;instead.
    </Message>
  </>
);

export default SignUpForm;
