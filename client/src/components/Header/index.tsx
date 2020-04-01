import * as React from 'react';
import { useState, useEffect } from 'react';
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
  const [activeItem, setActiveItem] = useState('');
  useEffect(() => {
    setActiveItem(currentItem);
  }, [currentItem]);

  const clickHandler = (item: MainHeaderItems, isSetItem?: boolean) => {
    setActiveItem(isSetItem ? item : '');
    onMenuItemClick(item);
  };

  return (
    <header>
      <Menu size='large'>
        <Container>
          <Menu.Item onClick={() => clickHandler(MainHeaderItems.Home)}>
            <img src={logo} alt="logo" />
          </Menu.Item>
          <Menu.Item
            name={MainHeaderItems.Chat}
            active={activeItem === MainHeaderItems.Chat}
            onClick={() => clickHandler(MainHeaderItems.Chat, true)}
          />
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
