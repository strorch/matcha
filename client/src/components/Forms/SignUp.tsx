import * as React from 'react';
import { Field, FormikProps } from 'formik';
import { Link } from 'react-router-dom';
import { Button, Form, Icon, Message, Grid } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';
import { ISignUpFormValues } from 'containers/SignUp';
import LabeledInput from 'components/FormikElements/LabeledInput';

interface ISignUpForm extends Pick<FormikProps<ISignUpFormValues>, 'errors' | 'touched' | 'handleSubmit' > {
  isFetching: boolean;
}

const SignUpForm = ({ errors, touched, isFetching, handleSubmit }: ISignUpForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Message
        attached
        header='Welcome to Matcha!'
      />
      <Form className='attached fluid segment' onSubmit={handleSubmit}>
        <Field
          name='firstName'
          label="First name:"
          placeholder='First Name'
          component={LabeledInput}
          error={touched.firstName && errors.firstName}
        />
        <Field
          name='lastName'
          label="Last name:"
          placeholder='Last Name'
          component={LabeledInput}
          error={touched.lastName && errors.lastName}
        />
        <Field
          name="username"
          label="Username:"
          placeholder="Username"
          autoComplete="username"
          component={LabeledInput}
          error={touched.username && errors.username}
        />
        <Field
          name="email"
          label="Email:"
          placeholder="Email"
          autoComplete="none"
          component={LabeledInput}
          error={touched.email && errors.email}
        />
        <Field
          type="password"
          name="password"
          label="Password:"
          placeholder="Password"
          autoComplete="new-password"
          component={LabeledInput}
          error={touched.password && errors.password}
        />
        <Field
          type="password"
          name="passwordConfirm"
          label="Confirm password:"
          autoComplete="new-password"
          placeholder="Confirm password"
          component={LabeledInput}
          error={touched.passwordConfirm && errors.passwordConfirm}
        />
        <Button
          fluid
          color="blue"
          type="submit"
          loading={isFetching}
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
