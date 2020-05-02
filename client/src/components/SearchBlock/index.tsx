import React, { useState } from 'react';
import { Segment, Header, Container } from 'semantic-ui-react';
import SearchBar from 'components/SearchBar';

const SearchBlock = () => {
  const [isAdvanced, setIsAdvanced] = useState<boolean>(false);
  
  return (
    <>
      <Segment vertical padded>
        <Container textAlign='center'>
          <SearchBar
            isAdvancedSearch={isAdvanced}
            toggleIsAdvancedSearch={() => setIsAdvanced(!isAdvanced)}
          />
          {
            isAdvanced
              ? (
                <Header as='h2'>Advanced</Header>
              ) : (
                <Header as='h2'>Not Advanced</Header>
              )
          }
        </Container>
      </Segment>
     </>
    );
};

export default SearchBlock;
