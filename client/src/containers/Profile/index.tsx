import * as React from 'react';
import { connect } from 'react-redux';
import { RouteComponentProps } from 'react-router';
import { IUserState } from 'models';
import { useCheckForInitialInfo } from 'hooks';

interface Profile extends RouteComponentProps {
  isInitialInfoSet: Pick<IUserState, 'isInitialInfoSet'>;
}

const Profile = ({ isInitialInfoSet, history }: Profile) => {
  useCheckForInitialInfo(history, isInitialInfoSet);

  return <div />;
};

const mapStateToProps = state => ({
  isInitialInfoSet: state.general.user.isInitialInfoSet
});

export default connect(
  mapStateToProps
)(Profile);
