import * as React from 'react';
import { useEffect } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { Segment } from 'semantic-ui-react';
import { withFormik, FormikProps } from 'formik';
import { RouteComponentProps } from 'react-router';
import { Actions } from 'actions';
import { Forms } from 'components';
import { IUserState, Gender } from 'models';
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
}

type ISetInitialInfo = IOuterProps & FormikProps<ISetInitialInfoFormValues>;

const SetInitialInfo = ({
  errors,
  touched,
  history,
  handleSubmit,
  user: { isFetching, isInitialInfoSet }
}: ISetInitialInfo) => {
  useEffect(() => {
    if (isInitialInfoSet) history.push(GeneralRoutes.Main);
  }, [isInitialInfoSet, history]);

  const handleAddInterest = (interest: string) => {
    console.log('Add: ', interest);
  }

  return (
    <Segment vertical padded>
      <Forms.InitialInfo
        errors={errors}
        touched={touched}
        isFetching={isFetching}
        handleSubmit={handleSubmit}
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
  user: state.general.user
});
const mapDispatchToProps = dispatch => ({
  actions: bindActionCreators(Actions, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(WithFormik);
