import { GeneralRoutes } from 'routes';

export const initReducer = {
  isFetching: false,
  data: null,
  error: null,
};

export interface IGeneralState {
  socketStatus: SocketConnectionStatus;
  user: IUserState;
}

export interface IUserState {
  isAuthenticated: boolean;
  isInitialInfoSet: boolean;
  isLocalStorageChecking: boolean;
  isFetching: boolean;
  data: IUser;
  error: any;
}

export interface IUser {
  firstName: string;
  lastName: string;
  username: string;
  email: string;
  isConfirmed: boolean;
  gender: Gender;
  sexualPref: Gender;
  bio: string;
  interests: string[];
  images: any[];
}

export enum SocketConnectionStatus {
  Off = 'OFF',
  On = 'ON',
}

export enum MainHeaderItems {
  Home = 'home',
  Profile = 'profile',
  Chat = 'chat',
  SignUp = 'sign-up',
  SignIn = 'sign-in',
  SetInitialInfo = 'set-initial-info',
}

export const routeByHeaderItem = {
  [MainHeaderItems.Home]: GeneralRoutes.Main,
  [MainHeaderItems.Profile]: GeneralRoutes.Profile,
  [MainHeaderItems.Chat]: GeneralRoutes.Chat,
  [MainHeaderItems.SignUp]: GeneralRoutes.SignUp,
  [MainHeaderItems.SignIn]: GeneralRoutes.SignIn,
  [MainHeaderItems.SetInitialInfo]: GeneralRoutes.SetInitialInfo,
};

export enum Gender {
  Male = 'male',
  Female = 'female',
  Other = 'other',
}

export interface IFormDataState {
  interests: IInterestsState;
  newInterests: IInterest[];
}

export interface IInterestsState {
  isFetching: boolean;
  data: IInterest[];
  error: any; // FIXME: fix any
}

export interface IInterest {
  id: number;
  title: string;
}

export interface IUsersState {
  currentProfile: IProfileState;
}

export interface IProfileState {
  isFetching: boolean;
  data: IProfile;
  error: any;
}

export interface IProfile {
  id: number;
}
