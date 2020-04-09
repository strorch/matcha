export const makeDropdownListFromObject = (obj: object) =>
  Object.keys(obj).map(key => ({
    text: key,
    value: obj[key]
  }));
