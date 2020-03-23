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
  <Form.Field>
    <label>{label}</label>
    <textarea
      name={name}
      value={value}
      onChange={event => {
        setFieldValue(name, event.target.value);
      }}
      {...props}
    />
  </Form.Field>
);

export default LabeledTextarea;
