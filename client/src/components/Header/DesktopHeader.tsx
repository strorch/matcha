import * as React from 'react';
import { Menu, Container, Button } from 'semantic-ui-react';
import logo from 'assets/logo.svg';
import { MainHeaderItems } from 'models';

interface IDesktopHeaderProps {
  isAuthenticated: boolean;
  isUserReady: boolean;
  currentItem: string;
  
  onSignOutClick(): void;
  clickHandler(item: MainHeaderItems): void;
}

const DesktopHeader = ({
  isAuthenticated,
  isUserReady,
  currentItem,
  onSignOutClick,
  clickHandler
}: IDesktopHeaderProps) => (
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
                onClick={() => clickHandler(MainHeaderItems.Profile)}
              />
              <Menu.Item
                name={MainHeaderItems.Chat}
                active={currentItem === MainHeaderItems.Chat}
                onClick={() => clickHandler(MainHeaderItems.Chat)}
              />
            </>
          ) : isAuthenticated && (
            <Menu.Item
              name={MainHeaderItems.SetInitialInfo}
              active={currentItem === MainHeaderItems.SetInitialInfo}
              onClick={() => clickHandler(MainHeaderItems.SetInitialInfo)}
            />
          )
      }
      <Menu.Menu position='right'>
        {
          isAuthenticated
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
);

export default DesktopHeader;
