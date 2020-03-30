import * as React from 'react';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { Forms } from 'components';

interface IFormValues {
  email: string;
}

interface IOuterProps {
  temp?: string;
}

type IForgot = IOuterProps & FormikProps<IFormValues>;

const Forgot = ({ handleSubmit }: IForgot) => (
  <Segment vertical padded>
    <Forms.Forgot
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
    email: ''
  }),
})(Forgot);
