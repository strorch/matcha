import * as React from 'react';
import { Menu, Container, Header, Image, Button } from 'semantic-ui-react';
import logo from 'assets/logo.svg';
import { MainHeaderItems } from 'models';


interface IMobileHeaderProps {
  isAuthenticated: boolean;
  isUserReady: boolean;
  currentItem: string;
  
  onSignOutClick(): void;
  clickHandler(item: MainHeaderItems): void;
}

const MobileHeader = ({
  isAuthenticated,
  isUserReady,
  currentItem,
  onSignOutClick,
  clickHandler
}: IMobileHeaderProps) => (
  <Menu vertical fluid>
    <Container textAlign="center">
      <Menu.Item onClick={() => clickHandler(MainHeaderItems.Home)}>
        <Header as="h3">
          <Image src={logo} alt="logo" /> Matcha
        </Header>
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
    </Container>
  </Menu>
);

export default MobileHeader;
