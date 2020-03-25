import * as React from 'react';
import { Forms } from 'components';
import { Container, Segment } from 'semantic-ui-react';

const SignUp = () => (
  <Segment vertical padded>
    <Forms.SignUpForm />
  </Segment>
);

export default SignUp;
