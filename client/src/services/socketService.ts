import * as types from "actions/types";

enum MessageTypes {
  Chat = 'chat'
}

export const getMessageType = type => {
  switch (type) {
    case types.SEND_CHAT_MESSAGE:
      return MessageTypes.Chat;
    default:
      return 'no_type';
  }
};

export const getActionDoneType = type => {
  switch (type) {
    case MessageTypes.Chat:
      return types.SEND_CHAT_MESSAGE_DONE
    default:
      return 'no_type';
  }
};
