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
import { GeneralRoutes } from 'routes';
import { IUserState } from 'models';

export interface ISignInFormValues {
  username: string;
  password: string;
}

interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: IUserState;
}

type ISignIn = IOuterProps & FormikProps<ISignInFormValues>;

const SignIn = ({
  errors,
  touched,
  history,
  handleSubmit,
  user: { isFetching, isAuthenticated, isInitialInfoSet }
}: ISignIn) => {
  useEffect(() => {
    if (isAuthenticated) {
      history.push(isInitialInfoSet ? GeneralRoutes.Main : GeneralRoutes.SetInitialInfo);
    }
  }, [isAuthenticated, isInitialInfoSet, history]);
  
  return (
    <Segment vertical padded>
      <Forms.SignIn
        errors={errors}
        touched={touched}
        isFetching={isFetching}
        handleSubmit={handleSubmit}
      />
    </Segment>
  );
}

const WithFormik = withFormik<IOuterProps, ISignInFormValues>({
  handleSubmit: (values, { props: { actions, history } }) => {
    actions.signIn(values, history);  // Not the best decision but the easiest one
  },
  mapPropsToValues: () => ({
    username: '',
    password: ''
  }),
  validationSchema: () =>
    Yup.object().shape({
      username: validators.username,
      password: validators.password
    })
})(SignIn);

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
