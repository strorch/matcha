import { ApiRoutes } from 'routes';

export enum RequestTypes {
  Get = 'GET',
  Post = 'POST'
}

export interface RequestShape {
  type: string;
  endpoint: ApiRoutes;
  method: RequestTypes;
  data?: object;
};
