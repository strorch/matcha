import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { Segment, Message } from 'semantic-ui-react';
import { bindActionCreators } from 'redux';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import * as Yup from 'yup';
import * as validators from 'services/yupValidationService';
import { Forms } from 'components';
import { Actions } from 'actions';
import { IUserState } from 'models';
import { GeneralRoutes } from 'routes';

export interface ISignUpFormValues {
  firstName: string;
  lastName: string;
  username: string;
  email: string;
  password: string;
  passwordConfirm: string;
}

interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: IUserState;
}

type ISignUp = IOuterProps & FormikProps<ISignUpFormValues>;

const SignUp = ({
  actions,
  errors,
  touched,
  history,
  resetForm,
  handleSubmit,
  user: { isFetching, isAuthenticated, error }
}: ISignUp) => {
  useEffect(() => {
    if (isAuthenticated) history.push(GeneralRoutes.Main);
    return actions.clearUserError;
  }, [isAuthenticated, history]);

  const resetSignUpForm = () => {
    actions.clearUserError();
    resetForm();
  };

  return (
    <Segment vertical padded>
      <Forms.SignUp
        errors={errors}
        touched={touched}
        isFetching={isFetching}
        handleSubmit={handleSubmit}
      />
      {!!error && <Message attached negative content={error} onDismiss={resetSignUpForm} />}
    </Segment>
  );
}

const WithFormik = withFormik<IOuterProps, ISignUpFormValues>({
  handleSubmit: (values, { props: { actions, history } }) => {
    actions.signUp(values, history);  // Not the best decision but the easiest one
  },
  mapPropsToValues: () => ({
      firstName: '',
      lastName: '',
      username: '',
      email: '',
      password: '',
      passwordConfirm: ''
    }),
  validationSchema: () =>
    Yup.object().shape({
      firstName: validators.firstName,
      lastName: validators.lastName,
      username: validators.username,
      email: validators.email,
      password: validators.password,
      passwordConfirm: validators.passwordConfirm
    })
})(SignUp);

const mapStateToProps = state => ({
  user: state.general.user
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(WithFormik);
