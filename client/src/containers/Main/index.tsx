import * as React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Actions } from 'actions';
import { IUserState } from 'models';
import MainPages from 'components/MainPages';

interface IMainProps {
  user: IUserState;
}

const Main = ({ user }: IMainProps) => {
  const { isAuthenticated, isInitialInfoSet } = user;

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
        />
      );
    }
  };

  return renderMainPage();
};

const mapStateToProps = state => ({
  user: state.general.user
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Main);
