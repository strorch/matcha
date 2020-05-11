import React from 'react';
import { withFormik, FormikProps } from 'formik';
import { Segment, Container } from 'semantic-ui-react';
import { IInterestsState } from 'models';
import { SearchBar, AdvancedSearchBar } from 'components/MainSearchComponents';

export interface IFormValues {
  ageFrom: string;
  ageTo: string;
  fameRatingFrom: string;
  fameRatingTo: string;
  interests: number[];
  location: any; // FIXME: any
  searchQuery: string;
  isAdvancedSearch: boolean;
}

interface IOuterProps {
  interests: IInterestsState;
}

type ISearchBlock = IOuterProps & FormikProps<IFormValues>;

const SearchBlock = ({
  interests,
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
              <AdvancedSearchBar
                handleSearch={handleSubmit}
                interests={interests.data || []}
                isInterestsFetching={interests.isFetching}
              />
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
    ageFrom: '',
    ageTo: '',
    fameRatingFrom: '',
    fameRatingTo: '',
    interests: [],
    location: '',
    searchQuery: '',
    isAdvancedSearch: false
  })
})(SearchBlock);
