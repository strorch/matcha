import * as Yup from 'yup';

export const firstName = Yup.string().required('First name is required.');
export const lastName = Yup.string().required('Last name is required.');
export const username = Yup.string().required('Provide username too.');
export const email = Yup.string()
  .required('We need your email.')
  .matches(/^\S+@\S+$/, 'Enter a valid email');
export const password = Yup.string()
  .required('Create a strong password.')
  .matches(/^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/, "Password must contain: lowercase letters, uppercase letters and digits. Min. length - 8 symbols.")
export const passwordConfirm = Yup.string()
  .oneOf([Yup.ref('password')], 'Passwords don\'t match')
  .required('Confirm your password')
