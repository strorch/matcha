import * as React from 'react';
import { useMemo } from 'react';
import { Menu, Container, Button } from 'semantic-ui-react';
import logo from 'assets/logo.svg';
import { MainHeaderItems, IUserState } from 'models';

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

  const clickHandler = (item: MainHeaderItems, isSetItem?: boolean) => {
    onMenuItemClick(item);
  };

  const isUserReady = useMemo(() => {
    return !!(isAuthenticated && isInitialInfoSet);
  }, [isAuthenticated, isInitialInfoSet]);

  return (
    <header>
      <Menu size='large'>
        <Container>
          <Menu.Item onClick={() => clickHandler(MainHeaderItems.Home)}>
            <img src={logo} alt="logo" />
          </Menu.Item>
          {
            isUserReady
              ? (
                <>
                  <Menu.Item
                    name={MainHeaderItems.Profile}
                    active={currentItem === MainHeaderItems.Profile}
                    onClick={() => clickHandler(MainHeaderItems.Profile, true)}
                  />
                  <Menu.Item
                    name={MainHeaderItems.Chat}
                    active={currentItem === MainHeaderItems.Chat}
                    onClick={() => clickHandler(MainHeaderItems.Chat, true)}
                  />
                </>
              ) : isAuthenticated && (
                <Menu.Item
                  name={MainHeaderItems.SetInitialInfo}
                  active={currentItem === MainHeaderItems.SetInitialInfo}
                  onClick={() => clickHandler(MainHeaderItems.SetInitialInfo, true)}
                />
              )
          }
          <Menu.Menu position='right'>
            {
              currentUser.isAuthenticated
                ? (
                  <Menu.Item>
                    <Button
                      primary
                      onClick={onSignOutClick}
                    >
                      Sign Out
                    </Button>
                  </Menu.Item>
                ) : (
                  <>
                    <Menu.Item>
                      <Button
                        primary
                        onClick={() => clickHandler(MainHeaderItems.SignUp)}
                      >
                        Sign Up
                      </Button>
                    </Menu.Item>
                    <Menu.Item>
                      <Button onClick={() => clickHandler(MainHeaderItems.SignIn)}>Sign In</Button>
                    </Menu.Item>
                  </>
                )
            }
          </Menu.Menu>
        </Container>
      </Menu>
    </header>
  );
};

export default Header;
