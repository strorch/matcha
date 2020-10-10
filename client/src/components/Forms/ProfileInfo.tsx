import * as React from 'react';
import { useMemo } from 'react';
import { FormikProps, Field } from 'formik';
import { Grid, Form, Button, Image, Segment } from 'semantic-ui-react';
import { Gender, IInterestsState, IInterest } from 'models';
import user from 'assets/user.svg';
import {
  makeDropdownListFromObject,
  makeDropdownListFromObjArr,
} from 'helpers';
import { LabeledInput, LabeledSelect } from 'components/FormikElements';
import { ISetProfileInfoFormValues } from 'containers/SetProfileInfo';
import LabeledTextarea from 'components/FormikElements/LabeledTextarea';

interface IProfileInfoForm
  extends Pick<FormikProps<ISetProfileInfoFormValues>, 'handleSubmit'> {
  isFetching: boolean;
  allInterests: IInterestsState;
  newInterests: IInterest[];
  images: any[];
  onAddInterest(interest: string): void;
  updateUserImages(images: any[]): any;
}

const ProfileInfoForm = ({
  allInterests,
  newInterests,
  isFetching,
  images,
  handleSubmit,
  onAddInterest,
  updateUserImages,
}: IProfileInfoForm) => {
  const genderList = useMemo(() => makeDropdownListFromObject(Gender), []);
  const interestsList = useMemo(
    () =>
      makeDropdownListFromObjArr(
        allInterests.data
          ? [
              ...allInterests.data,
              ...newInterests.map((newInterest) => ({
                id: newInterest,
                title: newInterest,
              })),
            ]
          : null,
        'title',
        'id'
      ),
    [allInterests.data, newInterests]
  );
  const fileElem = React.useRef(null);
  const fileReader = new FileReader();

  const onAddImageClick = () => fileElem.current.click();

  const onFileInputChange = ({ target: { files } }) => {
    fileReader.readAsDataURL(files[0]);
    fileReader.addEventListener('load', ({ target: { result } }) => {
      if (images[4] !== user) {
        images[4] = result;
      } else {
        const emptyImage = images.find((image) => image === user);
        const imageIndex = images.indexOf(emptyImage);

        images[imageIndex] = result;
      }
      updateUserImages([...images]);
    });
  };

  const isImageClickable = (image: string, index: number) =>
    index !== 0 && image !== user;

  const setAsAvatar = (index: number) => () =>
    updateUserImages(
      Object.assign([], images, {
        0: images[index],
        [index]: images[0],
      })
    );

  return (
    <Grid centered doubling>
      <Grid.Column>
        <Form className="attached fluid segment" onSubmit={handleSubmit}>
          <Field name="firstName" label="First name" component={LabeledInput} />
          <Field name="lastName" label="Last name" component={LabeledInput} />
          <Field name="email" label="Email address" component={LabeledInput} />
          <Field
            name="gender"
            label="Gender"
            options={genderList}
            component={LabeledSelect}
          />
          <Field
            name="sexualPref"
            label="Sexual preferences"
            options={genderList}
            component={LabeledSelect}
          />
          <Field
            name="bio"
            label="Bio"
            component={LabeledTextarea}
            placeholder="Tell us about yourself.."
          />
          <Field
            name="interests"
            label="Interests"
            options={interestsList || []}
            component={LabeledSelect}
            allowAdditions
            search
            selection
            multiple
            loading={allInterests.isFetching}
            placeholder="#vegan #geek #piercing"
            onAddItem={(_, { value }) => onAddInterest(value)}
          />
          <Segment>
            <Segment>
              <Image.Group
                size="tiny"
                style={{
                  display: 'flex',
                  justifyContent: 'space-around',
                  flexWrap: 'wrap',
                }}
              >
                {images.map((image, index) => (
                  <div
                    key={index}
                    style={{
                      display: 'flex',
                      justifyContent: 'center',
                      alignItems: 'center',
                    }}
                  >
                    <Image
                      src={image}
                      circular={index === 0}
                      bordered
                      {...(isImageClickable(image, index) && {
                        onClick: setAsAvatar(index),
                        style: { cursor: 'pointer' },
                      })}
                    />
                  </div>
                ))}
              </Image.Group>
            </Segment>
            <input
              type="file"
              accept="image/*"
              style={{ display: 'none' }}
              ref={fileElem}
              onChange={onFileInputChange}
            />
            <Button type="button" onClick={onAddImageClick}>
              Add image
            </Button>
          </Segment>
          <Button fluid color="blue" type="submit" loading={isFetching}>
            Save
          </Button>
        </Form>
      </Grid.Column>
    </Grid>
  );
};

export default ProfileInfoForm;
