import * as React from 'react';
import { withRouter, RouteComponentProps } from "react-router-dom";
import { Header } from 'components';
import { MainHeaderItems, routeByHeaderItem } from 'models';

const MainHeader = ({
  history,
  location
}: RouteComponentProps) => {

  const onMenuItemClick = (item: MainHeaderItems) => history.push(routeByHeaderItem[item]);

  return (
    <Header
      onMenuItemClick={onMenuItemClick}
      currentItem={location.pathname.slice(1)}
    />
  );
};

export default withRouter(MainHeader);
