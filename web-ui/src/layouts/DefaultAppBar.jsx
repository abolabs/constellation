// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

// external-lib
import * as React from "react";
import { Logout, UserMenu, AppBar, useTranslate } from "react-admin";
import { Link } from "react-router-dom";

import { useTheme } from "@mui/material/styles";
import MenuItem from "@mui/material/MenuItem";
import Typography from "@mui/material/Typography";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import SettingsIcon from "@mui/icons-material/Settings";
import Brightness4Icon from "@mui/icons-material/Brightness4";
import Brightness7Icon from "@mui/icons-material/Brightness7";
import IconButton from "@mui/material/IconButton";
// local
import ColorModeContext from "@contexts/ColorModeContext";
import { Avatar, SvgIcon } from "@mui/material";
import { ReactComponent as LogoSvg } from "@/logo50.svg";

// It's important to pass the ref to allow MUI to manage the keyboard navigation
const ConfigurationMenu = React.forwardRef((props, ref) => {
  const t = useTranslate();
  return (
    <MenuItem
      ref={ref}
      component={Link}
      // It's important to pass the props to allow MUI to manage the keyboard navigation
      {...props}
      to="/account/edit"
    >
      <ListItemIcon>
        <SettingsIcon />
      </ListItemIcon>
      <ListItemText>{t("Profile")}</ListItemText>
    </MenuItem>
  );
});

const AppUserMenu = (props) => (
  <UserMenu {...props} icon={<SettingsIcon />}>
    <ConfigurationMenu />
    <Logout />
  </UserMenu>
);

const ToggleThemeButton = (props) => {
  const theme = useTheme();
  const colorMode = React.useContext(ColorModeContext);

  return (
    <IconButton
      sx={{ ml: 1 }}
      onClick={colorMode.toggleColorMode}
      color="inherit"
    >
      {theme.palette.mode === "dark" ? (
        <Brightness7Icon />
      ) : (
        <Brightness4Icon />
      )}
    </IconButton>
  );
};

const DefaultAppBar = (props) => {
  const theme = useTheme();
  return (
    <AppBar
      sx={{
        background: "transparent",
        color: theme.palette.primary.main,
        boxShadow: "none",
        ".RaAppBar-toolbar": {
          minHeight: 0,
        },
      }}
      {...props}
      userMenu={<AppUserMenu />}
    >
      <Typography
        variant="h3"
        component="div"
        sx={{ flexGrow: 1, display: "flex", alignContent: "center" }}
      >
        <Avatar
          sx={{
            m: 1,
            bgcolor: "primary.main",
            height: "1.25rem",
            width: "1.25rem",
            p: 0,
            margin: "0.25rem",
            display: "inline-flex",
          }}
        >
          <SvgIcon
            component={LogoSvg}
            inheritViewBox
            shapeRendering="path"
            color="primary"
            sx={{
              path: {
                fill: `${theme.palette.primary.contrastText} !important`,
              },
              height: "80%",
              width: "80%",
            }}
          />
        </Avatar>
        Constellation
      </Typography>
      <ToggleThemeButton />
    </AppBar>
  );
};

export default DefaultAppBar;
