import * as React from 'react';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import * as Yup from 'yup';
import * as validators from 'services/yupValidationHelpers';
import { Forms } from 'components';

export interface IForgotFormValues {
  email: string;
}

interface IOuterProps {
  temp?: string;
}

type IForgot = IOuterProps & FormikProps<IForgotFormValues>;

const Forgot = ({ errors, touched, handleSubmit }: IForgot) => (
  <Segment vertical padded>
    <Forms.Forgot
      errors={errors}
      touched={touched}
      handleSubmit={handleSubmit}
    />
  </Segment>
);

export default withFormik<IOuterProps, IForgotFormValues>({
  handleSubmit: (values, { props, resetForm }) => {
    console.log('values: ', values);
    console.log('props: ', props);
    resetForm();
  },
  mapPropsToValues: () => ({
    email: ''
  }),
  validationSchema: () =>
    Yup.object().shape({
      email: validators.email
    })
})(Forgot);
