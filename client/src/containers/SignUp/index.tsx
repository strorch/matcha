import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { Segment } from 'semantic-ui-react';
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
