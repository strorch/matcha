import React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Grid, Image, Segment, Loader } from 'semantic-ui-react';
import { Actions } from 'actions';
import { IInterestsState } from 'models';
import MainSearch from 'containers/MainSearch';
import { FilterAndSortLine } from 'components/MainSearchComponents';

interface IMainPage {
  actions: typeof Actions;
  interests: IInterestsState;
}

const MainPage = ({ interests, actions }: IMainPage) => {
  // TODO: fetch cards!

  return (
    <>
      <MainSearch actions={actions} interests={interests} />
      <FilterAndSortLine />
      {
        false // isFetching
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

const mapStateToProps = state => ({
  interests: state.formData.interests
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(MainPage);
