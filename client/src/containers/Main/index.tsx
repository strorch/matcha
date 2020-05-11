import React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Actions } from 'actions';
import { MainPages } from 'components';
import { MainSearch } from 'containers';
import { IUserState, IInterestsState } from 'models';
import useConditionalFetch from 'hooks/useConditionalFetch';
import { FilterAndSortLine } from 'components/MainSearchComponents';

interface IMainProps {
  user: IUserState;
  actions: typeof Actions;
  interests: IInterestsState;
}

const Main = ({ user, actions, interests }: IMainProps) => {
  const { isAuthenticated, isInitialInfoSet } = user;

  useConditionalFetch(interests, actions.fetchInterestsList);


  const renderMainPage = () => {
    if (!isAuthenticated) {
      return <MainPages.Option1 />;
    } else if (!isInitialInfoSet) {
      return <MainPages.Option2 />;
    } else {
      return (
        <MainPages.Option3
          cards={[]}
          isFetching={false}
          fetchCards={() => console.log('fetchCards')}
          searchBlock={<MainSearch interests={interests} />}
          filterAndSortLine={<FilterAndSortLine />}
        />
      );
    }
  };

  return renderMainPage();
};

const mapStateToProps = state => ({
  user: state.general.user,
  interests: state.formData.interests
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Main);
