export enum LocalStorageKeys {
  User = 'user'
}

export const getLocalStorageItem = (key: string, isJson?: boolean) => {
  const item = localStorage.getItem(key);
  if (item && isJson) {
    return JSON.parse(item);
  }
  return item || null;
}

export const setLocalStorageItem = (key: LocalStorageKeys, data: any) => {
  let dataToStore = '';
  if (typeof data === 'object') {
    dataToStore = JSON.stringify(data);
  } else if(typeof data !== 'string' && !!data.toString) {
    dataToStore = data.toString();
  } else {
    dataToStore = data;
  }
  localStorage.setItem(key, dataToStore as any);
}

export const removeLocalStorageItem = (key: LocalStorageKeys) => {
  localStorage.removeItem(key);
}
