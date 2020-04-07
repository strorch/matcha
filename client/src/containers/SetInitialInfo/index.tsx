import * as React from 'react';
import { Header } from 'semantic-ui-react';

interface ISetInitialInfo {
  temp?: string;
}

const SetInitialInfo = ({}: ISetInitialInfo) => {

  return (
    <>
      <Header as='h2'>
        Set Initial Info
      </Header>
    </>
  );
}

export default SetInitialInfo;
