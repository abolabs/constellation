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
import {
  AppBarClasses,
  HideOnScroll,
  LoadingIndicator,
  LocalesMenuButton,
  Logout,
  TitlePortal,
  UserMenu,
  useLocales,
  useSidebarState,
  useThemesContext,
  useTranslate,
} from "react-admin";
import { Link } from "react-router-dom";

import { AppBar as MuiAppBar, Toolbar } from "@mui/material";

import { styled, useTheme } from "@mui/material/styles";
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
import { Avatar, SvgIcon, useMediaQuery } from "@mui/material";
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

const DefaultToolbar = () => {
  const locales = useLocales();
  const { darkTheme } = useThemesContext();
  return (
    <>
      {locales && locales.length > 1 ? <LocalesMenuButton /> : null}
      {darkTheme && <ToggleThemeButton />}
      <LoadingIndicator />
    </>
  );
};

const defaultToolbarElement = <DefaultToolbar />;

const DefaultUserMenu = <UserMenu />;

const PREFIX = "RaAppBar";

const StyledAppBar = styled(MuiAppBar, {
  name: PREFIX,
  overridesResolver: (props, styles) => styles.root,
})(({ theme }) => ({
  [`& .${AppBarClasses.toolbar}`]: {
    padding: `0 ${theme.spacing(1)}`,
    [theme.breakpoints.down("md")]: {
      minHeight: theme.spacing(6),
    },
  },
  [`& .${AppBarClasses.menuButton}`]: {
    marginRight: "0.2em",
  },
  [`& .${AppBarClasses.title}`]: {},
}));

const AppBar = React.memo((props) => {
  const {
    alwaysOn,
    children,
    className,
    color = "secondary",
    open,
    title,
    toolbar = defaultToolbarElement,
    userMenu = DefaultUserMenu,
    container: Container = alwaysOn ? "div" : HideOnScroll,
    ...rest
  } = props;

  const isXSmall = useMediaQuery((theme) => theme.breakpoints.down("sm"));
  const theme = useTheme();
  // eslint-disable-next-line no-unused-vars
  const [_openSideBar, setOpenSideBar] = useSidebarState();

  return (
    <Container className={className}>
      <StyledAppBar className={AppBarClasses.appBar} color={color} {...rest}>
        <Toolbar
          disableGutters
          variant={isXSmall ? "regular" : "dense"}
          className={AppBarClasses.toolbar}
        >
          <Avatar
            onClick={() => setOpenSideBar(!open)}
            sx={{
              m: 1,
              bgcolor: "primary.main",
              height: "2rem",
              width: "2rem",
              p: 0,
              margin: "0.5rem 0.5rem 0.5rem 0rem",
              display: "inline-flex",
              "&:hover": {
                cursor: "pointer",
              },
              "&:active": {
                transition: theme.transitions.create(["transform"], {
                  easing: theme.transitions.easing.sharp,
                  duration: theme.transitions.duration.complex,
                }),
                transform: "rotate(-1turn)",
              },
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
          {React.Children.count(children) === 0 ? (
            <TitlePortal className={AppBarClasses.title} />
          ) : (
            children
          )}
          {toolbar}
          {typeof userMenu === "boolean" ? (
            userMenu === true ? (
              <UserMenu />
            ) : null
          ) : (
            userMenu
          )}
        </Toolbar>
      </StyledAppBar>
    </Container>
  );
});

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
        Constellation
      </Typography>
      <ToggleThemeButton />
    </AppBar>
  );
};

export default DefaultAppBar;
