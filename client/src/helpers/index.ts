export const makeDropdownListFromObject = (obj: object) =>
  Object.keys(obj).map(key => ({
    text: key,
    value: obj[key]
  }));

export const makeDropdownListFromObjArr = (arr: Array<any>, textField: string, valueField: string | number) =>
  arr && arr.map(el => ({
    text: el[textField],
    value: el[valueField]
  }));
