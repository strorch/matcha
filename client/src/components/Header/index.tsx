import * as React from 'react';
import { useMemo } from 'react';
import { Responsive } from 'semantic-ui-react';
import { MainHeaderItems, IUserState } from 'models';
import DesktopHeader from './DesktopHeader';
import MobileHeader from './MobileHeader';

interface IHeader {
  currentItem: string;
  currentUser: IUserState;
  onSignOutClick(): void;
  onMenuItemClick(item: MainHeaderItems): void;
}

const Header = ({
  currentUser,
  currentItem,
  onSignOutClick,
  onMenuItemClick
}: IHeader) => {
  const { isAuthenticated, isInitialInfoSet } = currentUser;

  const isUserReady = useMemo(() => {
    return !!(isAuthenticated && isInitialInfoSet);
  }, [isAuthenticated, isInitialInfoSet]);

  return (
    <header>
      <Responsive {...Responsive.onlyMobile}>
        <MobileHeader
          isAuthenticated={isAuthenticated}
          isUserReady={isUserReady}
          currentItem={currentItem}
          onSignOutClick={onSignOutClick}
          clickHandler={onMenuItemClick}
        />
      </Responsive>
      <Responsive minWidth={Responsive.onlyTablet.minWidth}>
        <DesktopHeader
          isAuthenticated={isAuthenticated}
          isUserReady={isUserReady}
          currentItem={currentItem}
          onSignOutClick={onSignOutClick}
          clickHandler={onMenuItemClick}
        />
      </Responsive>
    </header>
  );
};

export default Header;
