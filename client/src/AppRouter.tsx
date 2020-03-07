import * as React from 'react';
import { Suspense, lazy } from 'react';
import { Switch, Route, withRouter } from 'react-router-dom';

const Main = lazy(() => import('containers/Main'));
const Chat = lazy(() => import('containers/Chat'));

// TODO: add loader
const AppRouter = () => (
  <Suspense fallback={<div>Loading..</div>}>
    <Switch>
      <Route exact path="/" component={Main} />
      <Route path="/chat" component={Chat} />
    </Switch>
  </Suspense>
);

export default withRouter(AppRouter);
