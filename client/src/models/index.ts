export enum SocketConnectionStatus {
  Off = 'OFF',
  On = 'ON'
}

export interface IGeneralState {
  socketStatus: SocketConnectionStatus;
}
