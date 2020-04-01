import * as React from 'react';
import { connect } from 'react-redux';
import { FunctionComponent } from 'react';
import { Route, Redirect } from 'react-router-dom';
import { GeneralRoutes } from 'routes';

interface IProtectedRoute {
  component: FunctionComponent;
  isAuthenticated: boolean;
  path: string;
}

const ProtectedRoute = ({ component: Component, isAuthenticated, ...props }: IProtectedRoute) => (
  isAuthenticated ? <Route {...props} component={Component} /> : <Redirect to={GeneralRoutes.SignIn} />
);

export default connect(
  state => ({
    isAuthenticated: state.general.user.isAuthenticated
  })
)(ProtectedRoute);
