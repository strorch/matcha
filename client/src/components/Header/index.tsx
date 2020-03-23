import * as React from 'react';
import { useState } from 'react';
import logo from 'assets/logo.svg';
import { MainHeaderItems } from 'models';
import { Menu, Container } from 'semantic-ui-react';

interface IHeader {
  currentItem: string;
  onMenuItemClick(item: MainHeaderItems): void;
}

const Header = ({
  currentItem,
  onMenuItemClick
}: IHeader) => {
  const [activeItem, setActiveItem] = useState(currentItem || '');

  const handleClickHome = () => {
    setActiveItem('');
    onMenuItemClick(MainHeaderItems.Home);
  };

  return (
    <header>
      <Menu size='large'>
        <Container>
          <Menu.Item onClick={handleClickHome}>
            <img src={logo} alt="logo" />
          </Menu.Item>
          <Menu.Item
            name={MainHeaderItems.Chat}
            active={activeItem === MainHeaderItems.Chat}
            onClick={() => {
              setActiveItem(MainHeaderItems.Chat);
              onMenuItemClick(MainHeaderItems.Chat);
            }}
          />
        </Container>
      </Menu>
    </header>
  );
};

export default Header;
