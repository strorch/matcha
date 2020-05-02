import * as React from 'react';
import { useEffect } from 'react';
import { Grid, Image, Segment, Loader, Dropdown } from 'semantic-ui-react';
import SearchBlock from 'components/SearchBlock';
import SortLine from 'components/SortLine';
import FilterSelect from 'components/FilterSelect';

interface IMainOption3Props {
  cards?: object[]; // FIXME: fix any type
  fetchCards(): void;
  isFetching: boolean;
}

const MainOption3 = ({ cards, isFetching, fetchCards }: IMainOption3Props) => {
  useEffect(() => {
    fetchCards();
  }, [fetchCards]);
  
  const SortLineComponent = <SortLine />;
  const FilterComponent = <FilterSelect />;
  
  return (
    isFetching
      ? (
        <Loader content='Loading..' size="huge" active />
      ) : (
        <>
          <SearchBlock />
          <Segment vertical>
            <Grid container verticalAlign="middle">
              <Grid.Row columns={2}>
                <Grid.Column mobile={16} tablet={5} textAlign="center" only="tablet mobile">{FilterComponent}</Grid.Column>
                <Grid.Column width={8} floated="left" textAlign="left" only="computer">{FilterComponent}</Grid.Column>
                <Grid.Column width={8} floated="right" textAlign="right" only="computer">{SortLineComponent}</Grid.Column>
                <Grid.Column mobile={16} tablet={11} textAlign="center" only="tablet mobile">{SortLineComponent}</Grid.Column>
              </Grid.Row>
            </Grid>
          </Segment>
          <Segment vertical padded>
            <Grid columns={3}>
                {['1', '2', '3'] && ['1', '2', '3'].map(card => (
                  <Grid.Column>
                    <Image src='https://react.semantic-ui.com/images/wireframe/image.png' />
                  </Grid.Column>
                ))}
            </Grid>
          </Segment>
        </>
      )
  );
};

export default MainOption3;
