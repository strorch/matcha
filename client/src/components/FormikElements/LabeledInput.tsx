import * as React from "react";
import { FieldProps } from 'formik';
import { Form } from "semantic-ui-react";

interface ILabeledInput extends FieldProps {
  label: string;
}

const LabeledInput = ({
  form: { getFieldProps },
  field: { name },
  label,
  ...props
}: ILabeledInput) => (
  <Form.Input
    type="text"
    name={name}
    label={label}
    {...getFieldProps(name)}
    {...props}
  />
);

export default LabeledInput;
