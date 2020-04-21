import * as React from 'react';
import { useEffect } from 'react';
import { Grid, Image, Segment, Loader } from 'semantic-ui-react';

interface IMainOption3Props {
  cards?: object[]; // FIXME: fix any type
  fetchCards(): void;
  isFetching: boolean;
}

const MainOption3 = ({ cards, isFetching, fetchCards }: IMainOption3Props) => {
  useEffect(() => {
    fetchCards();
  }, [fetchCards]);
  
  return (
    isFetching
      ? (
        <Loader content='Loading..' size="huge" active />
      ) : (
        <Segment vertical padded>
          <Grid columns={3}>
              {cards && cards.map(card => (
                <Grid.Column>
                  <Image src='https://react.semantic-ui.com/images/wireframe/image.png' />
                </Grid.Column>
              ))}
          </Grid>
        </Segment>
      )
  );
};

export default MainOption3;
