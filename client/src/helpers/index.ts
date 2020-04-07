export const makeDropdownListFromEnum = (enumObj: object) =>
  Object.keys(enumObj).map(key => ({
    text: key,
    value: enumObj[key]
  }));
