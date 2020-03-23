import * as React from "react";
import { FieldProps } from 'formik';
import { Form } from "semantic-ui-react";

interface ILabeledInput extends FieldProps {
  label: string;
}

const LabeledInput = ({
  form: { setFieldValue },
  field: { name, value },
  label,
  ...props
}: ILabeledInput) => (
  <Form.Field>
    <label>{label}</label>
    <input
      type="text"
      name={name}
      value={value}
      onChange={event => {
        setFieldValue(name, event.target.value);
      }}
      {...props}
    />
  </Form.Field>
);

export default LabeledInput;
