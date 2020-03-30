import * as React from 'react';
import { Field } from 'formik';
import { Link } from 'react-router-dom';
import { Button, Form, Icon, Message, Grid } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';
import LabeledInput from 'components/FormikElements/LabeledInput';

interface ISignUpForm {
  handleSubmit(): void;
}

const SignUpForm = ({ handleSubmit }: ISignUpForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Message
        attached
        header='Welcome to Matcha!'
      />
      <Form className='attached fluid segment' onSubmit={handleSubmit}>
        <Field
          name='first_name'
          label="First name:"
          placeholder='First Name'
          component={LabeledInput}
        />
        <Field
          name='last_name'
          label="Last name:"
          placeholder='Last Name'
          component={LabeledInput}
        />
        <Field
          name="username"
          label="Username:"
          placeholder="Username"
          autoComplete="username"
          component={LabeledInput}
        />
        <Field
          type="password"
          name="password"
          label="Password:"
          placeholder="Password"
          autoComplete="new-password"
          component={LabeledInput}
        />
        <Field
          type="password"
          name="password_confirm"
          label="Confirm password:"
          autoComplete="new-password"
          placeholder="Confirm password"
          component={LabeledInput}
        />
        <Button
          fluid
          color="blue"
          type="submit"
        >
          Sign Up
        </Button>
      </Form>
      <Message attached='bottom' warning>
        <Icon name='help' />
        Already signed up?&nbsp;
        {
          <Link to={GeneralRoutes.SignIn}>Sign In</Link>
        }
        &nbsp;instead.
      </Message>
    </Grid.Column>
  </Grid>
);

export default SignUpForm;
