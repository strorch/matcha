import * as React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { withRouter, RouteComponentProps } from "react-router-dom";
import { Actions } from 'actions';
import { Header } from 'components';
import { MainHeaderItems, routeByHeaderItem, IUserState } from 'models';

interface IMainHeader extends RouteComponentProps {
  user: IUserState;
  actions: typeof Actions;
}

const MainHeader = ({
  user,
  actions,
  history,
  location
}: IMainHeader) => {
  const getCurrentItem = () => location.pathname.slice(1);
  const onMenuItemClick = (item: MainHeaderItems) => history.push(routeByHeaderItem[item]);

  return (
    <Header
      currentUser={user}
      currentItem={getCurrentItem()}
      onSignOutClick={actions.signOut}
      onMenuItemClick={onMenuItemClick}
    />
  );
};

const WithRouter = withRouter(MainHeader)

export default connect(
  state => ({
    user: state.general.user
  }),
  dispatch => ({
    actions: bindActionCreators(Actions, dispatch)
  })
)(WithRouter);
