import React from 'react';
import { Button, Input, Grid } from 'semantic-ui-react';

interface ISearchBarProps {
  isAdvancedSearch: boolean;
  toggleIsAdvancedSearch(): void;
}

const SearchBar = ({
  isAdvancedSearch,
  toggleIsAdvancedSearch
}: ISearchBarProps) => (
  <Grid container verticalAlign="middle" textAlign="center">
    <Grid.Column mobile={16} tablet={10} computer={12}>
      <Input
        fluid
        disabled={isAdvancedSearch}
        placeholder='Search by name..'
        action={{ icon: 'search', disabled: isAdvancedSearch }}
      />
    </Grid.Column>
    <Grid.Column mobile={16} tablet={6} computer={4}>
      <Button basic onClick={toggleIsAdvancedSearch}>{!isAdvancedSearch ? 'Open Advanced Search' : 'Hide Advanced Search'}</Button>
    </Grid.Column>
  </Grid>
);

export default SearchBar;
