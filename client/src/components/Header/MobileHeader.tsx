import * as React from 'react';
import { Menu, Container, Header, Image } from 'semantic-ui-react';
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
        <Header as="h2">
          <Image src={logo} alt="logo" /> Matcha
        </Header>
      </Menu.Item>
    </Container>
  </Menu>
);

export default MobileHeader;
