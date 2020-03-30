import * as React from 'react';
import { Grid, Message, Form, Button } from 'semantic-ui-react';
import LabeledInput from 'components/FormikElements/LabeledInput';
import { Field } from 'formik';

interface IForgotForm {
  handleSubmit(): void;
}

const ForgotForm = ({ handleSubmit }: IForgotForm) => (
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
