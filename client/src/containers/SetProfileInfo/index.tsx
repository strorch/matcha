import * as React from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { Actions } from 'actions';
import { Forms } from 'components';
import { IUserState, Gender, IInterestsState, IInterest } from 'models';
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
  allInterests: IInterestsState;
  newInterests: IInterest[];
  images: any[];
}

type ISetProfileInfo = IOuterProps & FormikProps<ISetProfileInfoFormValues>;

const SetProfileInfo = ({
  images,
  user,
  actions,
  allInterests,
  newInterests,
  handleSubmit,
}: ISetProfileInfo) => {
  useConditionalFetch(allInterests, actions.fetchInterestsList);

  const handleAddInterest = (interest: string) =>
    actions.addNewInterest(interest);

  const updateUserImages = (images: any[]) => actions.updateUserImages(images);

  return (
    <Segment vertical padded>
      <Forms.ProfileInfo
        allInterests={allInterests}
        newInterests={newInterests}
        handleSubmit={handleSubmit}
        isFetching={user.isFetching}
        onAddInterest={handleAddInterest}
        images={images}
        updateUserImages={updateUserImages}
      />
    </Segment>
  );
};

const WithFormik = withFormik<IOuterProps, ISetProfileInfoFormValues>({
  handleSubmit: (values, { props: { actions, images } }) =>
    actions.updateUserProfile({ ...values, images }),
  validate: () => {}, // todo
  mapPropsToValues: ({
    user: {
      data: { firstName, lastName, email, gender, sexualPref, bio, interests },
    },
  }) => ({
    firstName,
    lastName,
    email,
    gender,
    sexualPref,
    bio,
    interests,
  }),
})(SetProfileInfo);

const mapStateToProps = (state) => ({
  images: state.general.user.data.images,
  user: state.general.user,
  allInterests: state.formData.interests,
  newInterests: state.formData.newInterests,
});
const mapDispatchToProps = (dispatch) => ({
  actions: bindActionCreators(Actions, dispatch),
});

export default connect(mapStateToProps, mapDispatchToProps)(WithFormik);
