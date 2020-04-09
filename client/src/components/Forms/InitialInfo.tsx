import * as React from 'react';
import { useMemo } from 'react';
import { FormikProps, Field } from 'formik';
import { Grid, Form, Button, Message, Image, Segment } from 'semantic-ui-react';
import { Gender } from 'models';
import user from 'assets/user.svg';
import { makeDropdownListFromObject } from 'helpers';
import LabeledSelect from 'components/FormikElements/LabeledSelect';
import { ISetInitialInfoFormValues } from 'containers/SetInitialInfo';
import LabeledTextarea from 'components/FormikElements/LabeledTextarea';

interface IInitialInfoForm extends Pick<FormikProps<ISetInitialInfoFormValues>, 'errors' | 'touched' | 'handleSubmit'> {
  isFetching: boolean;
  onAddInterest(interest: string): void;
}

const InitialInfoForm = ({ touched, errors, isFetching, handleSubmit, onAddInterest }: IInitialInfoForm) => {
  const genderList = useMemo(() => makeDropdownListFromObject(Gender), []);
  
  return (
    <Grid centered columns={2} doubling>
      <Grid.Column>
        <Message
          attached
          header='Welcome to Matcha!'
          content='Please fill in your initial profile information.'
        />
        <Form className='attached fluid segment' onSubmit={handleSubmit}>
          <Field
            name='gender'
            label="Gender"
            options={genderList}
            component={LabeledSelect}
          />
          <Field
            name='sexualPref'
            label="Sexual preferences"
            options={genderList}
            component={LabeledSelect}
          />
          <Field
            name='bio'
            label='Bio'
            component={LabeledTextarea}
            placeholder='Tell us about yourself..'
          />
          <Field
            name='interests'
            label="Interests"
            options={[]}
            component={LabeledSelect}
            allowAdditions
            search
            selection
            multiple
            placeholder="#vegan #geek #piercing"
            onAddItem={(_, { value }) => onAddInterest(value)}
          />
          <Segment>
            <Segment>
              <Image.Group
                size='tiny'
                style={{ display: 'flex', justifyContent: 'space-around', flexWrap: 'wrap' }}
              >
                <Image src={user} circular bordered />
                <Image src={user} bordered />
                <Image src={user} bordered />
                <Image src={user} bordered />
                <Image src={user} bordered />
              </Image.Group>
            </Segment>
            <Button style={{ marginTop: '15px' }}>
              Add image
            </Button>
          </Segment>
          <Button
            fluid
            color="blue"
            type="submit"
            loading={isFetching}
          >
            Save
          </Button>
        </Form>
      </Grid.Column>
    </Grid>
  );
};

export default InitialInfoForm;
