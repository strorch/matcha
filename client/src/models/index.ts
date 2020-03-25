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
  Chat = 'chat',
  SignUp = 'sign-up',
  SignIn = 'sign-in'
}

export const routeByHeaderItem = {
  [MainHeaderItems.Home]: GeneralRoutes.Main,
  [MainHeaderItems.Chat]: GeneralRoutes.Chat,
  [MainHeaderItems.SignUp]: GeneralRoutes.SignUp,
  [MainHeaderItems.SignIn]: GeneralRoutes.SignIn
};
