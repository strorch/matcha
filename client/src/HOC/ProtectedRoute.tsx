import * as React from 'react';
import { FunctionComponent } from 'react';
import { Route } from 'react-router-dom';

interface IProtectedRoute {
  component: FunctionComponent;
  path: string;
}

const ProtectedRoute = ({ component: Component, ...props }: IProtectedRoute) => {
  console.log('ProtectedRouteProps: ', props);

  return (
    <Route {...props} component={Component} />
  );
};

export default ProtectedRoute;
