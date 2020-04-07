import * as React from 'react';
import { FormikProps } from 'formik';
import { Grid, Form, Button } from 'semantic-ui-react';
import { ISetInitialInfoFormValues } from 'containers/SetInitialInfo';

interface IInitialInfoForm extends Pick<FormikProps<ISetInitialInfoFormValues>, 'errors' | 'touched' | 'handleSubmit'> {
  isFetching: boolean;
}

const InitialInfoForm = ({ isFetching, handleSubmit }: IInitialInfoForm) => (
  <Grid centered columns={2} doubling>
    <Grid.Column>
      <Form className='attached fluid segment' onSubmit={handleSubmit}>
        <Button
          fluid
          color="blue"
          type="submit"
          loading={isFetching}
        >
          Save
        </Button>
      </Form>
    </Grid.Column>
  </Grid>
);

export default InitialInfoForm;
