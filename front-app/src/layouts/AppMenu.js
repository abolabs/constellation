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

import { Menu, useSidebarState } from "react-admin";

import AppRegistrationIcon from "@mui/icons-material/AppRegistration";
import ViewModuleIcon from "@mui/icons-material/ViewModule";
import WidgetsIcon from "@mui/icons-material/Widgets";
import SettingsSystemDaydreamIcon from "@mui/icons-material/SettingsSystemDaydream";
import ShareIcon from "@mui/icons-material/Share";
import WindowIcon from "@mui/icons-material/Window";
import AccountTreeIcon from "@mui/icons-material/AccountTree";
import StorageIcon from "@mui/icons-material/Storage";
import GroupsIcon from "@mui/icons-material/Groups";
import LocalOfferIcon from "@mui/icons-material/LocalOffer";
import PersonIcon from "@mui/icons-material/Person";
import HistoryIcon from '@mui/icons-material/History';
import Replay30Icon from '@mui/icons-material/Replay30';

import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";

import { useTheme } from "@mui/material/styles";
import { useMediaQuery, Avatar, Grid } from "@mui/material";
import { useGetIdentity } from 'ra-core';
import { useEffect } from "react";

const AppMenu = () => {
  const theme = useTheme();
  const isMediumOrUpper = useMediaQuery((theme) => theme.breakpoints.up("md"));
  const [open, setOpen] = useSidebarState(isMediumOrUpper);
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("sm"));
  const { isLoading, identity } = useGetIdentity();

  useEffect(( ) => {
    setOpen(isMediumOrUpper);
  }, [isMediumOrUpper, setOpen])

  return (
    <Menu
      sx={{
        color: theme.palette.primary.main,
        marginTop: 0,
        borderRadius: isSmall ? 0 : 1,
        mr: 3,
        pt: 0.5,
        pb:0.5,
        h4: {
          textAlign: "center",
          mt: 0.5,
          mb: 0.5,
        },
        h5: {
          textAlign: "center",
          mt: 0.5,
          mb: 0.5,
        },
        "& .SidebarAvatar":{
          pt: 1,
        },
        "&.RaMenu-open": {
          width: isSmall ? "100%" : "14rem",
          height: isSmall ? "100%" : "auto",
          ml: isSmall ? 0 : 1,
          p: isSmall ? 0 : "default",
          m: isSmall ? 0 : "default",
        },
        "&.RaMenu-closed":{
          ml:0.5,
          width: "2.5rem",
          ".MuiMenuItem-root":{
            m: 0,
            padding: "0.25rem",
          }
        },
        "& .MuiButtonBase-root .MuiSvgIcon-root": {
          background: theme.palette.background.paper,
          color: theme.palette.secondary.main,
          width: "2rem",
          height: "2rem",
          borderRadius: 1,
          mr: "0.5rem",
          p: 0.5,
          boxShadow: 1,
        },
        "& .MuiMenuItem-root": {
          borderRadius: 1,
          m: "0.25rem 0",
          fontSize: "0.85rem",
          color: theme.palette.primary.main,
        },
        "& .MuiButtonBase-root": {
          ".MuiListItemIcon-root": {
            minWidth: 0,
          },
        },

        "& .RaMenuItemLink-active": {
          color: `${theme.palette.primary.main}`,
          ".MuiSvgIcon-root": {
            background: theme.palette.primary.main,
            color: theme.palette.secondary.contrastText,
          },
        },
      }}
    >
      {!isLoading && open ?
        (
          <Grid container direction="column" alignItems="center" className="SidebarAvatar" mb={2}>
            <Grid item>
              <Avatar
                  className="RaUserMenu-avatar"
                  src={identity.avatar}
                  alt={identity.fullName}
              />
            </Grid>
            <Grid item>
              <Typography variant="h5" align="center">{identity.fullName}</Typography>
            </Grid>
          </Grid>
        ) : null
      }
      <Menu.DashboardItem />
      {open ? (
        <Typography variant="h4" pt={1}>Application mapping</Typography>
      ) : (
        <Divider />
      )}
      <Menu.Item
        to="/application-mapping/by-app"
        primaryText="Applications"
        leftIcon={<ShareIcon />}
      />
      {open ? (
        <Typography variant="h4" pt={1}>Entités</Typography>
      ) : (
        <Divider />
      )}
      <Menu.Item
        to="/applications"
        primaryText="Applications"
        leftIcon={<AppRegistrationIcon />}
      />
      <Menu.Item
        to="/service_instances"
        primaryText="Instances de services"
        leftIcon={<ViewModuleIcon />}
      />
      <Menu.Item
        to="/services"
        primaryText="Services"
        leftIcon={<WidgetsIcon />}
      />
      <Menu.Item
        to="/hostings"
        primaryText="Hébergements"
        leftIcon={<SettingsSystemDaydreamIcon />}
      />
      {open ? (
        <Typography variant="h4" pt={1}>Administration</Typography>
      ) : (
        <Divider />
      )}
      <Menu.Item
        to="/service_instance_dependencies"
        primaryText="Dépendances d'instances"
        leftIcon={<AccountTreeIcon />}
      />
      <Menu.Item
        to="/environnements"
        primaryText="Environnements"
        leftIcon={<WindowIcon />}
      />
      <Menu.Item
        to="/service_versions"
        primaryText="Versions de service"
        leftIcon={<Replay30Icon />}
      />
      <Menu.Item
        to="/hosting_types"
        primaryText="Types d'hébergement"
        leftIcon={<StorageIcon />}
      />
      <Menu.Item
        to="/teams"
        primaryText="Equipes"
        leftIcon={<GroupsIcon />}
      />
      <Menu.Item
        to="/users"
        primaryText="Utilisateurs"
        leftIcon={<PersonIcon />}
      />
      <Menu.Item
        to="/roles"
        primaryText="Roles"
        leftIcon={<LocalOfferIcon />}
      />
      <Menu.Item
        to="/audits"
        primaryText="Audits"
        leftIcon={<HistoryIcon />}
      />
    </Menu>
  );
};

export default AppMenu;
