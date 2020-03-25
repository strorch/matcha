import * as React from 'react';
import { Suspense, lazy } from 'react';
import { Switch, Route, withRouter } from 'react-router-dom';
import { GeneralRoutes } from 'routes';
import { Footer } from 'components';
import { MainHeader } from 'containers';
import { Container } from 'semantic-ui-react';

const Main = lazy(() => import('containers/Main'));
const Chat = lazy(() => import('containers/Chat'));
const SignIn = lazy(() => import('containers/SignIn'));
const SignUp = lazy(() => import('containers/SignUp'));

// TODO: add loader
const AppRouter = () => (
  <div className="global-app-container">
    <MainHeader />
    <Container className="app-container">
      <Suspense fallback={<div>Loading..</div>}>
        <Switch>
          <Route exact path={GeneralRoutes.Main} component={Main} />
          <Route path={GeneralRoutes.Chat} component={Chat} />
          <Route path={GeneralRoutes.SignIn} component={SignIn} />
          <Route path={GeneralRoutes.SignUp} component={SignUp} />
        </Switch>
      </Suspense>
    </Container>
    <Footer />
  </div>
);

export default withRouter(AppRouter);
