import * as React from 'react';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom';
import { bindActionCreators } from 'redux';
import { Button, Form } from 'semantic-ui-react';
import { Field, withFormik, FormikProps } from 'formik';
import { Actions } from 'actions';
import { GeneralRoutes } from 'routes';
import { LabeledInput, LabeledTextarea } from 'components/Forms';

interface FormValues {
  name: string;
  message: string;
}
interface OuterProps {
  actions: typeof Actions;
}

type IChat = OuterProps & FormikProps<FormValues>;

const Chat = ({ handleSubmit }: IChat) => {
  return (
    <>
      <h1>Chat!</h1>
      
      <Form onSubmit={handleSubmit}>
        <Field
          name="name"
          label="Name"
          placeholder="Your name"
          component={LabeledInput}
        />
        <Field
          name="message"
          label="Message"
          placeholder="Your message"
          component={LabeledTextarea}
        />
        <Button type='submit'>Send</Button>
      </Form>

      <Link to={GeneralRoutes.Main}>
        <Button>Main</Button>
      </Link>
    </>
  );
}

const WithFormik = withFormik<OuterProps, FormValues>({
  mapPropsToValues: () => ({
    name: '',
    message: ''
  }),
  handleSubmit: (values, { props: { actions }, ...formikBag }) => {
    console.log('values', values);
    console.log('formikBag', formikBag);
    actions.sendTestChatMessage(values.name, values.message);
  }
})(Chat);

const mapStateToProps = state => state;
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(WithFormik);
