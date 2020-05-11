import React from 'react';
import { Button } from 'semantic-ui-react';

interface IAdvancedSearchBar {
  handleSearch(): void;
}

const AdvancedSearchBar = ({ handleSearch }: IAdvancedSearchBar) => (
  // <Grid container verticalAlign="middle" textAlign="center">
  //   <Grid.Column mobile={16} tablet={10} computer={12}>
  //     <Input
  //       fluid
  //       disabled={isAdvancedSearch}
  //       placeholder='Search by name..'
  //       action={{ icon: 'search', disabled: isAdvancedSearch }}
  //     />
  //   </Grid.Column>
  //   <Grid.Column mobile={16} tablet={6} computer={4}>
  //     <Button basic onClick={toggleIsAdvancedSearch}>{!isAdvancedSearch ? 'Open Advanced Search' : 'Hide Advanced Search'}</Button>
  //   </Grid.Column>
  // </Grid>
  <Button basic color='blue' content='Apply' onClick={handleSearch} type="button" />
);

export default AdvancedSearchBar;
