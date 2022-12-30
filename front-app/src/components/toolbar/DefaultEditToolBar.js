import * as React from "react";
import {
    Toolbar,
    SaveButton,
} from 'react-admin';

const DefaultEditToolBar = props => (
  <Toolbar
      {...props}
      sx={{ display: 'flex', justifyContent: 'space-between' }}
  >
      <SaveButton />
  </Toolbar>
);

export default DefaultEditToolBar;
