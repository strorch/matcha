import React from 'react';
import { Field } from 'formik';
import { Button, Grid } from 'semantic-ui-react';
import LabeledInput from 'components/FormikElements/LabeledInput';

interface ISearchBarProps {
  handleSearch(): void;
  isAdvancedSearch: boolean;
  toggleIsAdvancedSearch(): void;
}

const SearchBar = ({
  handleSearch,
  isAdvancedSearch,
  toggleIsAdvancedSearch
}: ISearchBarProps) => (
  <Grid container verticalAlign="middle" textAlign="center">
    <Grid.Column mobile={16} tablet={10} computer={12}>
       <Field
          fluid
          name="searchQuery"
          component={LabeledInput}
          disabled={isAdvancedSearch}
          placeholder='Search by name..'
          action={
            <Button icon='search' disabled={isAdvancedSearch} onClick={handleSearch} type='button' />
          }
        />
    </Grid.Column>
    <Grid.Column mobile={16} tablet={6} computer={4}>
      <Button basic onClick={toggleIsAdvancedSearch}>{!isAdvancedSearch ? 'Open Advanced Search' : 'Hide Advanced Search'}</Button>
    </Grid.Column>
  </Grid>
);

export default SearchBar;
