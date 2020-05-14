import React from 'react';
import { Field } from 'formik';
import { Button, Grid, Form } from 'semantic-ui-react';
import { IInterest } from 'models';
import { makeDropdownListFromObjArr } from 'helpers';
import { LabeledInput, LabeledSelect } from 'components/FormikElements';

interface IAdvancedSearchBar {
  handleSearch(): void;
  interests: IInterest[];
  isInterestsFetching: boolean;
}

const AdvancedSearchBar = ({ handleSearch, interests, isInterestsFetching }: IAdvancedSearchBar) => (
  <Form onSubmit={handleSearch}>
    <Grid container verticalAlign="middle" textAlign="center">
      <Grid.Row>
        <Grid.Column width={8} textAlign="left">
          <Field
            name="ageFrom"
            label="Age from"
            placeholder="18"
            component={LabeledInput}
          />
        </Grid.Column>
        <Grid.Column width={8} textAlign="left">
          <Field
            name="ageTo"
            label="Age to"
            placeholder="45"
            component={LabeledInput}
          />
        </Grid.Column>
      </Grid.Row>
      <Grid.Row>
        <Grid.Column width={8} textAlign="left">
          <Field
            placeholder="18"
            name="fameRatingFrom"
            label="Fame Rating From"
            component={LabeledInput}
          />
        </Grid.Column>
        <Grid.Column width={8} textAlign="left">
          <Field
            placeholder="45"
            name="fameRatingTo"
            label="Fame Rating To"
            component={LabeledInput}
          />
        </Grid.Column>
      </Grid.Row>
      <Grid.Row children={
        <Field
          search
          multiple
          name="interests"
          label="Interests"
          component={LabeledSelect}
          loading={isInterestsFetching}
          placeholder="#vegan #geek #piercing"
          options={makeDropdownListFromObjArr(interests, 'title', 'id')}
        />
      } />
      <Grid.Row children={
        <Field
          placeholder="Kyiv"
          name="location"
          label="Location"
          component={LabeledInput}
        />
      } />
      <Grid.Row children={
        <Button basic color='blue' content='Apply' type="submit" />
      } />
    </Grid>
  </Form>
);

export default AdvancedSearchBar;
