import * as React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Button, Form } from 'semantic-ui-react';
import { RouteComponentProps } from 'react-router';
import { Field, withFormik, FormikProps } from 'formik';
import { Actions } from 'actions';
import { IUserState } from 'models';
import { FormikElements } from 'components';
import { useCheckForInitialInfo } from 'hooks';

interface IFormValues {
  sender_id: string;
  receiver_id: string;
  message: string;
}
interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  isInitialInfoSet: Pick<IUserState, 'isInitialInfoSet'>;
}

type Chat = IOuterProps & FormikProps<IFormValues>;

const Chat = ({ isInitialInfoSet, history, handleSubmit }: Chat) => {
  useCheckForInitialInfo(history, isInitialInfoSet);
  
  const { LabeledInput, LabeledTextarea } = FormikElements;
  
  return (
    <>
      <h1>Chat!</h1>
      
      <Form onSubmit={handleSubmit}>
        <Field
          name="sender_id"
          label="Sender id:"
          placeholder="Sender id"
          component={LabeledInput}
        />
        <Field
          name="receiver_id"
          label="Receiver id:"
          placeholder="Receiver id"
          component={LabeledInput}
        />
        <Field
          name="message"
          label="Message:"
          placeholder="Message"
          component={LabeledTextarea}
        />
        <Button type='submit'>Send</Button>
      </Form>
    </>
  );
}

const WithFormik = withFormik<IOuterProps, IFormValues>({
  mapPropsToValues: () => ({
    sender_id: '',
    receiver_id: '',
    message: ''
  }),
  handleSubmit: (values, { props: { actions }, resetForm, ...formikBag }) => {
    console.log('values', values);
    console.log('formikBag', formikBag);
    actions.sendChatMessage(values.sender_id, values.receiver_id, values.message);
    resetForm();
  }
})(Chat);

const mapStateToProps = state => ({
  isInitialInfoSet: state.general.user.isInitialInfoSet
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(WithFormik);
