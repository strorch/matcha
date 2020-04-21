import * as React from 'react';
import { useEffect } from 'react';
import { Grid, Image, Segment } from 'semantic-ui-react';

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
    <Segment vertical padded>
      {isFetching
        ? <div>Loading...</div>
        : (
          <Grid columns={3}>
            {cards && cards.map(card => (
              <Grid.Column>
                <Image src='https://react.semantic-ui.com/images/wireframe/image.png' />
              </Grid.Column>
            ))}
          </Grid>
        )}
    </Segment>
  );
};

export default MainOption3;
