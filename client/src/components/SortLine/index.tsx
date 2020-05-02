import React, { useState } from 'react';
import { Menu } from 'semantic-ui-react';

enum SortOptions {
  Rating = 'rating',
  Age = 'age',
  Location = 'location',
  Tags = 'tags'
}

const SortLine = () => {
  const [activeItem, setActiveItem] = useState('');
  const handleSortOptionChange = (e, item) => setActiveItem(item.name);

  return (
    <Menu text compact>
      <Menu.Item header>Sort By</Menu.Item>
      <Menu.Item
        name={SortOptions.Rating}
        active={activeItem === SortOptions.Rating}
        onClick={handleSortOptionChange}
      />
      <Menu.Item
        name='age'
        active={activeItem === SortOptions.Age}
        onClick={handleSortOptionChange}
      />
      <Menu.Item
        name='location'
        active={activeItem === SortOptions.Location}
        onClick={handleSortOptionChange}
      />
      <Menu.Item
        name='tags'
        active={activeItem === SortOptions.Tags}
        onClick={handleSortOptionChange}
      />
    </Menu>
  );
};

export default SortLine;
