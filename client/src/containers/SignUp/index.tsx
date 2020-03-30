import * as React from 'react';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { Forms } from 'components';

interface IFormValues {
  first_name: string;
  last_name: string;
  username: string;
  password: string;
  password_confirm: string;
}

interface IOuterProps {
  temp?: string;
}

type ISignUp = IOuterProps & FormikProps<IFormValues>;

const SignUp = ({ handleSubmit }: ISignUp) => (
  <Segment vertical padded>
    <Forms.SignUp
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
    first_name: '',
    last_name: '',
    username: '',
    password: '',
    password_confirm: ''
  }),
})(SignUp);
