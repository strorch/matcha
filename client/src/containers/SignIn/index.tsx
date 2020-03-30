import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { Segment } from 'semantic-ui-react';
import { bindActionCreators } from 'redux';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import { Forms } from 'components';
import { Actions } from 'actions';
import { GeneralRoutes } from 'routes';

export interface ISignInFormValues {
  username: string;
  password: string;
}

interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: {
    isFetching: boolean;
    isAuthenticated: boolean;
  }
}

type ISignIn = IOuterProps & FormikProps<ISignInFormValues>;

const SignIn = ({
  history,
  handleSubmit, 
  user: { isFetching, isAuthenticated }
}: ISignIn) => {
  useEffect(() => {
    if (isAuthenticated) history.push(GeneralRoutes.Main);
  }, [isAuthenticated, history]);
  
  return (
    <Segment vertical padded>
      <Forms.SignIn
        isFetching={isFetching}
        handleSubmit={handleSubmit}
      />
    </Segment>
  );
}

const WithFormik = withFormik<IOuterProps, ISignInFormValues>({
  handleSubmit: (values, { props: { actions } }) => {
    actions.signIn(values);
  },
  mapPropsToValues: () => ({
    username: '',
    password: ''
  }),
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
