import * as React from "react";
import { FieldProps } from 'formik';
import { Form } from "semantic-ui-react";

interface ILabeledTextarea extends FieldProps {
  label: string;
}

const LabeledTextarea = ({
  form: { getFieldProps },
  field: { name },
  label,
  ...props
}: ILabeledTextarea) => (
  <Form.TextArea
    name={name}
    label={label}
    {...getFieldProps(name)}
    {...props}
  />
);

export default LabeledTextarea;
