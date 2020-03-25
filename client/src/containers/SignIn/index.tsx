import * as React from 'react';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { Forms } from 'components';

interface IFormValues {
  username: string;
  password: string;
}

interface IOuterProps {
  temp?: string;
}

type ISignIn = IOuterProps & FormikProps<IFormValues>;

const SignIn = ({ handleSubmit }: ISignIn) => (
  <Segment vertical padded>
    <Forms.SignInForm
      handleSubmit={handleSubmit}
    />
  </Segment>
);

export default withFormik<IOuterProps, IFormValues>({
  handleSubmit: (values, { props, resetForm }) => {
    console.log('values: ', values);
    console.log('props: ', props);
    resetForm();
  },
  mapPropsToValues: () => ({
    username: '',
    password: ''
  }),
})(SignIn);
