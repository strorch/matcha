import * as React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { Actions } from 'actions';
import { Forms } from 'components';
import { IUserState, Gender, IInterestsState } from 'models';
import useConditionalFetch from 'hooks/useConditionalFetch';

export interface ISetProfileInfoFormValues {
  firstName: string;
  lastName: string;
  email: string;
  gender: Gender;
  sexualPref: Gender;
  bio: string;
  interests: string[];
}
interface IOuterProps {
  actions: typeof Actions;
  user: IUserState;
  interests: IInterestsState;
}

type ISetProfileInfo = IOuterProps & FormikProps<ISetProfileInfoFormValues>;

const SetProfileInfo = ({
  user,
  actions,
  interests,
  handleSubmit,
}: ISetProfileInfo) => {
  useConditionalFetch(interests, actions.fetchInterestsList);

  const handleAddInterest = (interest: string) => {
    console.log('Add: ', interest);
  };

  return (
    <Segment vertical padded>
      <Forms.ProfileInfo
        interests={interests}
        handleSubmit={handleSubmit}
        isFetching={user.isFetching}
        onAddInterest={handleAddInterest}
      />
    </Segment>
  );
};

const WithFormik = withFormik<IOuterProps, ISetProfileInfoFormValues>({
  handleSubmit: (values, { props: { actions } }) =>
    actions.updateUserProfile(values),
  mapPropsToValues: ({
    user: {
      data: { firstName, lastName, email },
    },
  }) => {
    return {
      firstName,
      lastName,
      email,
      gender: Gender.Male,
      sexualPref: Gender.Female,
      bio: '',
      interests: [],
    };
  },
})(SetProfileInfo);

const mapStateToProps = (state) => ({
  user: state.general.user,
  interests: state.formData.interests,
});
const mapDispatchToProps = (dispatch) => ({
  actions: bindActionCreators(Actions, dispatch),
});

export default connect(mapStateToProps, mapDispatchToProps)(WithFormik);
