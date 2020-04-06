import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import * as Yup from 'yup';
import * as validators from 'services/yupValidationHelpers';
import { Actions } from 'actions';
import { Forms } from 'components';
import { IUserState } from 'models';
import { GeneralRoutes } from 'routes';

export interface IForgotFormValues {
  email: string;
}

interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: IUserState;
}

type IForgot = IOuterProps & FormikProps<IForgotFormValues>;

const Forgot = ({ user: { isAuthenticated }, history, errors, touched, handleSubmit }: IForgot) => {
  useEffect(() => {
    if (isAuthenticated) history.push(GeneralRoutes.Main);
  }, [isAuthenticated, history]);
  
  return (
    <Segment vertical padded>
      <Forms.Forgot
        errors={errors}
        touched={touched}
        handleSubmit={handleSubmit}
      />
    </Segment>
  );
};

const WithFormik = withFormik<IOuterProps, IForgotFormValues>({
  handleSubmit: (values, { props, resetForm }) => {
    console.log('values: ', values);
    console.log('props: ', props);
    resetForm();
  },
  mapPropsToValues: () => ({
    email: ''
  }),
  validationSchema: () =>
    Yup.object().shape({
      email: validators.email
    })
})(Forgot);

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
