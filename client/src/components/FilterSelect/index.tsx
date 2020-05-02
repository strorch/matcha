import React from 'react';
import { Dropdown } from 'semantic-ui-react';
import { makeDropdownListFromObject } from 'helpers';

enum FilterOptions {
  Rating = 'rating',
  Age = 'age',
  Location = 'location',
  Tags = 'tags'
}

const FilterSelect = () => {
  const options = makeDropdownListFromObject(FilterOptions);

  return (
    <Dropdown
      text='Filter Users'
      icon='filter'
      floating
      labeled
      button
      className='icon'
    >
      <Dropdown.Menu>
        {options.map((option) => (
            <Dropdown.Item key={option.value} {...option} />
          ))}
      </Dropdown.Menu>
    </Dropdown>
  );
};

export default FilterSelect;
