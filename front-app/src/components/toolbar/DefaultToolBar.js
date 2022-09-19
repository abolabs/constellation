import {
  TopToolbar,
  FilterButton,
  CreateButton,
  ExportButton,
} from 'react-admin';

const DefaultToolBar = () => (
  <TopToolbar>
    <FilterButton/>
    <CreateButton />
    <ExportButton />
  </TopToolbar >
);

export default DefaultToolBar;
