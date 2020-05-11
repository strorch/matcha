import React from 'react';
import { Segment, Grid } from 'semantic-ui-react';
import SortLine from 'components/SortLine';
import FilterSelect from 'components/FilterSelect';

const FilterAndSortLine = () => (
  <Segment vertical>
    <Grid container verticalAlign="middle">
      <Grid.Row columns={2}>
        <Grid.Column mobile={16} tablet={5} textAlign="center" only="tablet mobile"><FilterSelect /></Grid.Column>
        <Grid.Column width={8} floated="left" textAlign="left" only="computer"><FilterSelect /></Grid.Column>
        <Grid.Column width={8} floated="right" textAlign="right" only="computer"><SortLine /></Grid.Column>
        <Grid.Column mobile={16} tablet={11} textAlign="center" only="tablet mobile"><SortLine /></Grid.Column>
      </Grid.Row>
    </Grid>
  </Segment>
);

export default FilterAndSortLine;
