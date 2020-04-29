import React, { useEffect } from 'react';
import { connect } from 'react-redux';
import { Loader } from 'semantic-ui-react';
import { bindActionCreators } from 'redux';
import { RouteComponentProps } from 'react-router';
import { Actions } from 'actions';
import { ProfilePage } from 'components';
import { useCheckForInitialInfo } from 'hooks';
import { IUserState, IProfileState } from 'models';

interface IProfile extends RouteComponentProps<any> {
  user: IUserState;
  actions: typeof Actions;
  currentProfile: IProfileState;
}

const Profile = ({
  match,
  history,
  actions,
  user: {
    isInitialInfoSet,
    data: user
  },
  currentProfile: {
    isFetching
  }
}: IProfile) => {
  useCheckForInitialInfo(history, isInitialInfoSet);

  useEffect(() => {
    const { id } = match.params;

    if (id) {
      // NOT YOUR profile
      actions.fetchUserProfile(+id);
    } else {
      // YOUR profile
      actions.setCurrentUserProfile(user);
    }
    return actions.clearCurrentProfile;
  }, [actions, match.params, user]);

  return (
    isFetching
      ? <Loader size="huge" active />
      : <ProfilePage />
  );
};

const mapStateToProps = state => ({
  user: state.general.user,
  currentProfile: state.users.currentProfile
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Profile);
