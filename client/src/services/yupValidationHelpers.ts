import * as Yup from 'yup';

export const firstName = Yup.string().required();
export const lastName = Yup.string().required();
export const username = Yup.string().required();
export const email = Yup.string().required();
export const password = Yup.string().required();
