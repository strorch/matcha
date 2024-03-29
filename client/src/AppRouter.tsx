import * as React from 'react';
import { Suspense, lazy } from 'react';
import { Switch, Route, withRouter } from 'react-router-dom';
import { Container, Loader } from 'semantic-ui-react';
import { GeneralRoutes } from 'routes';
import { Footer } from 'components';
import { MainHeader } from 'containers';
import { ProtectedRoute } from 'HOC';

const Main = lazy(() => import('containers/Main'));
const Chat = lazy(() => import('containers/Chat'));
const Profile = lazy(() => import('containers/Profile'));
const SignIn = lazy(() => import('containers/SignIn'));
const SignUp = lazy(() => import('containers/SignUp'));
const Forgot = lazy(() => import('containers/Forgot'));
const SetInitialInfo = lazy(() => import('containers/SetInitialInfo'));
const MessagePage = lazy(() => import('components/MessagePage'));
const NotFoundPage = lazy(() => import('components/NotFoundPage'));

const AppRouter = () => (
  <div className="global-app-container">
    <MainHeader />
    <Container className="app-container">
      <Suspense fallback={<Loader size="huge" active />}>
        <Switch>
          <Route exact path={GeneralRoutes.Main} component={Main} />
          <ProtectedRoute path={GeneralRoutes.Chat} component={Chat} />
          <ProtectedRoute path={`${GeneralRoutes.Profile}/:id?`} component={Profile} />
          <ProtectedRoute path={GeneralRoutes.SetInitialInfo} component={SetInitialInfo} />
          <Route path={GeneralRoutes.SignIn} component={SignIn} />
          <Route path={GeneralRoutes.SignUp} component={SignUp} />
          <Route path={GeneralRoutes.Forgot} component={Forgot} />
          <Route path={GeneralRoutes.Message} component={MessagePage} />
          <Route component={NotFoundPage} />
        </Switch>
      </Suspense>
    </Container>
    <Footer />
  </div>
);

export default withRouter(AppRouter);
