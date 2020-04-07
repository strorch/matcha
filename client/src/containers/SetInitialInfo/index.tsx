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
}
interface IOuterProps extends RouteComponentProps {
  actions: typeof Actions;
  user: IUserState;
}

type ISetInitialInfo = IOuterProps & FormikProps<ISetInitialInfoFormValues>;

const SetInitialInfo = ({
  history,
  handleSubmit,
  user: { isFetching, isInitialInfoSet }
}: ISetInitialInfo) => {
  useEffect(() => {
    if (isInitialInfoSet) history.push(GeneralRoutes.Main);
  }, [isInitialInfoSet, history]);

  return (
    <Segment vertical padded>
      <Forms.InitialInfo
        errors={{}}
        touched={{}}
        isFetching={isFetching}
        handleSubmit={handleSubmit}
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
      gender: Gender.Male
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
