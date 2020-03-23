import * as React from 'react';
import { Container } from 'semantic-ui-react';

const Footer = () => (
  <footer>
    <Container text>
      <p className="centered-text">
        Second project on Web branch -&nbsp;
        <strong><a href="#">Matcha</a></strong> created by&nbsp;
        <a href="#">mstorcha</a> and <a href="#">vlvereta</a> for&nbsp;
        <span className="no-wrap"><a href="#">UNIT_Factory</a> &copy;</span>
      </p>
    </Container>
  </footer>
);

export default Footer;
