import * as React from 'react';
import { Forms } from 'components';
import { Segment } from 'semantic-ui-react';

const SignIn = () => (
  <Segment vertical padded>
    <Forms.SignInForm />
  </Segment>
);

export default SignIn;
