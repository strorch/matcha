import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import { Actions } from 'actions';
import { Forms } from 'components';
import { IUserState, Gender, IInterestsState } from 'models';
import { GeneralRoutes } from 'routes';

export interface ISetInitialInfoFormValues {
  gender: Gender;
  sexualPref: Gender;
  bio: string;
  interests: string[];
}
interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: IUserState;
  interests: IInterestsState;
}

type ISetInitialInfo = IOuterProps & FormikProps<ISetInitialInfoFormValues>;

const SetInitialInfo = ({
  user,
  actions,
  history,
  interests,
  handleSubmit
}: ISetInitialInfo) => {
  useEffect(() => {
    if (user.isInitialInfoSet) {
      history.push(GeneralRoutes.Main);
    }

    actions.fetchInterestsList();
  }, [user.isInitialInfoSet, history, actions]);

  const handleAddInterest = (interest: string) => {
    console.log('Add: ', interest);
  }

  return (
    <Segment vertical padded>
      <Forms.InitialInfo
        interests={interests}
        handleSubmit={handleSubmit}
        isFetching={user.isFetching}
        onAddInterest={handleAddInterest}
      />
    </Segment>
  );
}

const WithFormik = withFormik<IOuterProps, ISetInitialInfoFormValues>({
  handleSubmit: (values, { props: { actions, history } }) => {
    console.log(values);
    // actions.updateUser(values, history);  // Not the best decision but the easiest one
  },
  mapPropsToValues: () => ({
      gender: Gender.Male,
      sexualPref: Gender.Female,
      bio: '',
      interests: []
    })
})(SetInitialInfo);

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
)(WithFormik);
