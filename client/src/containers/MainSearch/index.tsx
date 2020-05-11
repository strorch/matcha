import React from 'react';
import { withFormik, FormikProps } from 'formik';
import { Segment, Container } from 'semantic-ui-react';
import { SearchBar, AdvancedSearchBar } from 'components/MainSearchComponents';

export interface IFormValues {
  ageFrom: number;
  ageTo: number;
  fameRatingFrom: number;
  fameRatingTo: number;
  interests: number[];
  location: any; // FIXME: any
  searchQuery: string;
  isAdvancedSearch: boolean;
}

interface IOuterProps {
  temp?: string;
}

type ISearchBlock = IOuterProps & FormikProps<IFormValues>;

const SearchBlock = ({
  values: {
    isAdvancedSearch
  },
  handleSubmit,
  setFieldValue
}: ISearchBlock) => {
  
  return (
    <>
      <Segment vertical padded>
        <Container textAlign='center'>
          <SearchBar
            handleSearch={handleSubmit}
            isAdvancedSearch={isAdvancedSearch}
            toggleIsAdvancedSearch={() => setFieldValue('isAdvancedSearch', !isAdvancedSearch)}
          />
          {
            isAdvancedSearch && (
              <AdvancedSearchBar handleSearch={handleSubmit} />
            )
          }
        </Container>
      </Segment>
     </>
    );
};

export default withFormik<IOuterProps, IFormValues>({
  handleSubmit: values => console.log(values),
  mapPropsToValues: () => ({
    ageFrom: undefined,
    ageTo: undefined,
    fameRatingFrom: undefined,
    fameRatingTo: undefined,
    interests: [],
    location: '',
    searchQuery: '',
    isAdvancedSearch: false
  })
})(SearchBlock);
