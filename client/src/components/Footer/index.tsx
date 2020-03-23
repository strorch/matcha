import * as React from 'react';
import { Container } from 'semantic-ui-react';

const Footer = () => (
  <footer>
    <Container text>
      <p className="centered-text">
        Second project on Web branch -&nbsp;
        <strong><a href="https://projects.intra.42.fr/projects/matcha" target="_blank">Matcha</a></strong> created by&nbsp;
        <a href="https://profile.intra.42.fr/users/mstorcha" target="_blank">mstorcha</a> and <a href="https://profile.intra.42.fr/users/vlvereta" target="_blank">vlvereta</a> for&nbsp;
        <span className="no-wrap"><a href="https://unit.ua" target="_blank">UNIT_Factory</a> &copy;</span>
      </p>
    </Container>
  </footer>
);

export default Footer;
