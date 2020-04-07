import { useEffect } from 'react';
import { History } from 'history';
import { IUserState } from 'models';
import { GeneralRoutes } from 'routes';

const useCheckForInitialInfo = (
  history: History,
  isInitialInfoSet: Pick<IUserState, 'isInitialInfoSet'>
) => {
  useEffect(() => {
    if (!isInitialInfoSet) history.push(GeneralRoutes.SetInitialInfo);
  }, [isInitialInfoSet]);
};

export default useCheckForInitialInfo;
