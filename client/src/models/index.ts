import { GeneralRoutes } from "routes";

export interface IGeneralState {
  socketStatus: SocketConnectionStatus;
}

export enum SocketConnectionStatus {
  Off = 'OFF',
  On = 'ON'
}

export enum MainHeaderItems {
  Home = 'home',
  Chat = 'chat'
}

export const routeByHeaderItem = {
  [MainHeaderItems.Home]: GeneralRoutes.Main,
  [MainHeaderItems.Chat]: GeneralRoutes.Chat
};
