import * as React from 'react';
import { Grid, Message, Form, Button } from 'semantic-ui-react';
import { Field, FormikProps } from 'formik';
import { IForgotFormValues } from 'containers/Forgot';
import LabeledInput from 'components/FormikElements/LabeledInput';

type IForgotForm = Pick<FormikProps<IForgotFormValues>, 'errors' | 'touched' | 'handleSubmit'>;

const ForgotForm = ({ errors, touched, handleSubmit }: IForgotForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Message
        attached
        header='Restore you password'
      />
      <Form className='attached fluid segment' onSubmit={handleSubmit}>
        <Field
          name="email"
          label="Email:"
          placeholder="Email"
          component={LabeledInput}
          error={touched.email && errors.email}
        />
        <Button
          fluid
          color="blue"
          type="submit"
        >
          Send instructions
        </Button>
      </Form>
    </Grid.Column>
  </Grid>
);

export default ForgotForm;
