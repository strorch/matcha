import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { Segment } from 'semantic-ui-react';
import { bindActionCreators } from 'redux';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import * as Yup from 'yup';
import * as validators from 'services/yupValidationHelpers';
import { Forms } from 'components';
import { Actions } from 'actions';
import { IUser, IUserState } from 'models';
import { GeneralRoutes } from 'routes';

export interface ISignUpFormValues {
  first_name: string;
  last_name: string;
  username: string;
  email: string;
  password: string;
  password_confirm: string;
}

interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: IUserState;
}

type ISignUp = IOuterProps & FormikProps<ISignUpFormValues>;

const SignUp = ({
  errors,
  touched,
  history,
  handleSubmit, 
  user: { isFetching, isAuthenticated }
}: ISignUp) => {
  useEffect(() => {
    if (isAuthenticated) history.push(GeneralRoutes.Main);
  }, [isAuthenticated, history]);

  return (
    <Segment vertical padded>
      <Forms.SignUp
        errors={errors}
        touched={touched}
        isFetching={isFetching}
        handleSubmit={handleSubmit}
      />
    </Segment>
  );
}

const WithFormik = withFormik<IOuterProps, ISignUpFormValues>({
  handleSubmit: (values, { props: { actions, history } }) => {
    actions.signUp(values, history);  // Not the best decision but the easiest one
  },
  mapPropsToValues: () => ({
      first_name: '',
      last_name: '',
      username: '',
      email: '',
      password: '',
      password_confirm: ''
    }),
  validationSchema: () =>
    Yup.object().shape({
      first_name: validators.firstName,
      last_name: validators.lastName,
      username: validators.username,
      email: validators.email,
      password: validators.password,
      password_confirm: validators.passwordConfirm
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
