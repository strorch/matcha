import * as React from 'react';
import { useState } from 'react';
import logo from 'assets/logo.svg';
import { MainHeaderItems } from 'models';
import { Menu, Container, Button } from 'semantic-ui-react';

interface IHeader {
  currentItem: string;
  onMenuItemClick(item: MainHeaderItems): void;
}

const Header = ({
  currentItem,
  onMenuItemClick
}: IHeader) => {
  const [activeItem, setActiveItem] = useState(currentItem || '');

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
          </Menu.Menu>
        </Container>
      </Menu>
    </header>
  );
};

export default Header;
