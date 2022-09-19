import * as React from 'react';
import { Logout, UserMenu, useUserMenu, useLocaleState, AppBar } from 'react-admin';

import { Link } from 'react-router-dom';
import MenuItem from '@mui/material/MenuItem';

// Icons
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import LanguageIcon from '@mui/icons-material/Language';
import SettingsIcon from '@mui/icons-material/Settings';

// It's important to pass the ref to allow MUI to manage the keyboard navigation
const ConfigurationMenu = React.forwardRef((props, ref) => {
  return (
    <MenuItem
      ref={ref}
      component={Link}
      // It's important to pass the props to allow MUI to manage the keyboard navigation
      {...props}
      to="/configuration"
    >
      <ListItemIcon>
        <SettingsIcon />
      </ListItemIcon>
      <ListItemText>
        Configuration
      </ListItemText>
    </MenuItem>
  );
});

// It's important to pass the ref to allow MUI to manage the keyboard navigation
const SwitchLanguage = React.forwardRef((props, ref) => {
  const [locale, setLocale] = useLocaleState();
  // We are not using MenuItemLink so we retrieve the onClose function from the UserContext
  const { onClose } = useUserMenu();

  return (
    <MenuItem
      ref={ref}
      // It's important to pass the props to allow MUI to manage the keyboard navigation
      {...props}
      sx={{ color: 'text.secondary' }}
      onClick={event => {
        setLocale(locale === 'en' ? 'fr' : 'en');
        onClose(); // Close the menu
      }}
    >
      <ListItemIcon sx={{ minWidth: 5 }}>
        <LanguageIcon />
      </ListItemIcon>
      <ListItemText>
        Switch Language
      </ListItemText>
    </MenuItem>
  );
});

const AppUserMenu = props => (
  <UserMenu {...props}>
    <ConfigurationMenu />
    <SwitchLanguage />
    <Logout />
  </UserMenu>
);

const DefaultAppBar = props => <AppBar {...props} userMenu={<AppUserMenu />} />;

export default DefaultAppBar;
