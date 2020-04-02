import * as React from 'react';
import { Field, FormikProps } from 'formik';
import { Link } from 'react-router-dom';
import { Grid, Form, Button, Message, Icon } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';
import { ISignInFormValues } from 'containers/SignIn';
import LabeledInput from 'components/FormikElements/LabeledInput';

interface ISignInForm extends Pick<FormikProps<ISignInFormValues>, 'errors' | 'handleSubmit'> {
  isFetching: boolean;
}

const SignInForm = ({ errors, isFetching, handleSubmit }: ISignInForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Message
        attached
        header='Welcome to Matcha!'
      />
      <Form className='attached fluid segment' onSubmit={handleSubmit}>
        <Field
          name="username"
          label="Username:"
          placeholder="Username"
          autoComplete="username"
          component={LabeledInput}
          error={errors.username}
        />
        <Field
          type="password"
          name="password"
          label="Password:"
          placeholder="Password"
          autoComplete="current-password"
          component={LabeledInput}
          error={errors.password}
        />
        <Button
          fluid
          color="blue"
          type="submit"
          loading={isFetching}
        >
          Sign In
        </Button>
      </Form>
      <Message attached='bottom' warning>
        <Icon name='help' />
        Forgot your password? Click&nbsp;
        {
          <Link to={GeneralRoutes.Forgot}>here</Link>
        }
        &nbsp;to restore or&nbsp;
        {
          <Link to={GeneralRoutes.SignUp}>Sign Up</Link>
        }
        &nbsp;.
      </Message>
    </Grid.Column>
  </Grid>
);

export default SignInForm;
