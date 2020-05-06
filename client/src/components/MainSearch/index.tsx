import React, { useState } from 'react';
import { Segment, Container } from 'semantic-ui-react';
import SearchBar from './SearchBar';
import AdvancedSearchBar from './AdvancedSearchBar';

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
            isAdvanced && (
              <AdvancedSearchBar />
            )
          }
        </Container>
      </Segment>
     </>
    );
};

export default SearchBlock;
