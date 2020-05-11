import { useEffect } from 'react';

type Entity = {
  data: any | null;
  isFetching: boolean;
}

type Action = () => void;

const useConditionalFetch = (entity: Entity, action: Action) => {
  useEffect(() => {
    if (!entity.data && !entity.isFetching) action();
  }, [entity, action]);
};

export default useConditionalFetch;
