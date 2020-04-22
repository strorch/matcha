import * as React from "react";
import { FieldProps } from 'formik';
import { Form, DropdownItemProps } from "semantic-ui-react";

interface ILabeledSelect extends FieldProps {
  label: string;
  options: DropdownItemProps[];
}

const LabeledSelect = ({
  form: { setFieldValue },
  field: { name, value },
  label,
  options,
  ...props
}: ILabeledSelect) => (
  <Form.Select
    type="text"
    name={name}
    label={label}
    value={value}
    options={options}
    onChange={(_, { value }) => setFieldValue(name, value)}
    {...props}
  />
);

export default LabeledSelect;
