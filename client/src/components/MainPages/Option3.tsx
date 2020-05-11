import React, { useEffect } from 'react';
import { Grid, Image, Segment, Loader } from 'semantic-ui-react';

interface IMainOption3Props {
  cards?: object[]; // FIXME: fix any type
  fetchCards(): void;
  isFetching: boolean;
  searchBlock: React.ReactNode;
  filterAndSortLine: React.ReactNode;
};

const MainOption3 = ({ cards, isFetching, fetchCards, searchBlock, filterAndSortLine }: IMainOption3Props) => {
  useEffect(() => {
    fetchCards();
  }, [fetchCards]);
  
  return (
    <>
      {searchBlock}
      {filterAndSortLine}
      {
        isFetching
          ? (
            <Loader content='Loading..' size="huge" active />
          ) : (
            <Segment vertical padded>
              <Grid columns={3}>
                  {['1', '2', '3'] && ['1', '2', '3'].map(card => (
                    <Grid.Column key={card}>
                      <Image src='https://react.semantic-ui.com/images/wireframe/image.png' />
                    </Grid.Column>
                  ))}
              </Grid>
            </Segment>
          )
      }
    </>
  );
};

export default MainOption3;
