import React from 'react';
import { connect } from 'react-redux';
import MainPage from './MainPage';
import { IUserState } from 'models';
import { MainPages } from 'components';

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
      return <MainPage />;
    }
  };

  return renderMainPage();
};

const mapStateToProps = state => ({
  user: state.general.user
});

export default connect(
  mapStateToProps
)(Main);
