import * as React from 'react';
import { Link } from 'react-router-dom';
import { Button, Form } from 'semantic-ui-react';
import { Field, withFormik } from 'formik';
import { GeneralRoutes } from 'routes';
import { LabeledInput, LabeledTextarea } from 'components/Forms';

interface FormValues {
  name: string;
  message: string;
}
interface IChat {
  test?: string;
}

const Chat = ({ handleSubmit }) => (
  <>
    <h1>Chat!</h1>
    
    <Form onSubmit={handleSubmit}>
      <Field
        name="name"
        label="Name"
        placeholder="Test test test"
        component={LabeledInput}
      />
      <Field
        name="message"
        label="Message"
        placeholder="Test test test"
        component={LabeledTextarea}
      />
      <Button type='submit'>Send</Button>
    </Form>

    <Link to={GeneralRoutes.Main}>
      <Button>Main</Button>
    </Link>
  </>
);

export default withFormik<any, FormValues>({
  mapPropsToValues: () => ({
    name: '',
    message: ''
  }),
  handleSubmit: (values, formikBag) => {
    console.log('values', values);
    console.log('formikBag', formikBag);
  }
})(Chat);
