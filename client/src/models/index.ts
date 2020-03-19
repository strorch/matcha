export interface IGeneralState {
  socketStatus: SocketConnectionStatus;
}

export enum SocketConnectionStatus {
  Off = 'OFF',
  On = 'ON'
}
