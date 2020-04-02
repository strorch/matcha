import * as React from "react";
import { FieldProps } from 'formik';
import { Form } from "semantic-ui-react";

interface ILabeledTextarea extends FieldProps {
  label: string;
}

const LabeledTextarea = ({
  form: { setFieldValue },
  field: { name, value },
  label,
  ...props
}: ILabeledTextarea) => (
  <Form.TextArea
    name={name}
    label={label}
    value={value}
    onChange={event => {
      setFieldValue(name, (event.target as HTMLInputElement).value);
    }}
    {...props}
  />
);

export default LabeledTextarea;
