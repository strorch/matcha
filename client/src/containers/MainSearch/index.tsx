import React, { useEffect } from 'react';
import { withFormik, FormikProps } from 'formik';
import { Segment, Container } from 'semantic-ui-react';
import { Actions } from 'actions';
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
  actions: typeof Actions;
  interests: IInterestsState;
}

type ISearchBlock = IOuterProps & FormikProps<IFormValues>;

const SearchBlock = ({
  actions,
  interests,
  values: {
    isAdvancedSearch
  },
  handleSubmit,
  setFieldValue
}: ISearchBlock) => {
  useEffect(() => {
    if (isAdvancedSearch && !interests.data && !interests.isFetching) {
      actions.fetchInterestsList();
    }
  }, [isAdvancedSearch, interests, actions]);

  const handleToggleIsAdvancedSearch = () => {
    setFieldValue('searchQuery', '');
    setFieldValue('isAdvancedSearch', !isAdvancedSearch);
  };

  return (
    <>
      <Segment vertical padded>
        <Container textAlign='center'>
          <SearchBar
            handleSearch={handleSubmit}
            isAdvancedSearch={isAdvancedSearch}
            toggleIsAdvancedSearch={handleToggleIsAdvancedSearch}
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
