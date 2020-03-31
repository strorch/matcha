import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { Segment } from 'semantic-ui-react';
import { bindActionCreators } from 'redux';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import { Forms } from 'components';
import { Actions } from 'actions';
import { IUser } from 'models';
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
  user: {
    isFetching: boolean;
    isAuthenticated: boolean;
    data: IUser;
  };
}

type ISignUp = IOuterProps & FormikProps<ISignUpFormValues>;

const SignUp = ({
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
