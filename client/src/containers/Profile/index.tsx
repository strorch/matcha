import React, { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { RouteComponentProps } from 'react-router';
import { Actions } from 'actions';
import { IUserState, IUsersState } from 'models';
import { ProfilePage } from 'components';
import { useCheckForInitialInfo } from 'hooks';

interface IProfile extends RouteComponentProps<any> {
  user: IUserState;
  users: IUsersState;
  actions: typeof Actions;
}

const Profile = ({
  match,
  history,
  actions,
  user: {
    isInitialInfoSet,
    data: user
  }
}: IProfile) => {
  useCheckForInitialInfo(history, isInitialInfoSet);

  useEffect(() => {
    const { id } = match.params;

    if (id) {
      // NOT YOUR profile
      // actions.fetchUserProfile(id);
    } else {
      // YOUR profile
      actions.setCurrentProfile(user);
    }
    return actions.clearCurrentProfile;
  }, [actions, match.params, user]);

  return (
    <ProfilePage />
  );
};

const mapStateToProps = state => ({
  user: state.general.user,
  users: state.users
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Profile);
