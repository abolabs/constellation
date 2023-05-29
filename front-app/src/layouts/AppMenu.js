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

import { Menu, useSidebarState, usePermissions } from "react-admin";

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
import HistoryIcon from "@mui/icons-material/History";
import Replay30Icon from "@mui/icons-material/Replay30";
import LanIcon from "@mui/icons-material/Lan";
import WebAssetIcon from "@mui/icons-material/WebAsset";
import KeyboardArrowUpIcon from "@mui/icons-material/KeyboardArrowUp";
import KeyboardArrowDownIcon from "@mui/icons-material/KeyboardArrowDown";

import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";

import { useTheme } from "@mui/material/styles";
import { useMediaQuery, Grid, Collapse } from "@mui/material";
import { useGetIdentity } from "ra-core";
import { useEffect, useState } from "react";
import Gravatar from "react-gravatar";

const AppMenu = () => {
  const theme = useTheme();
  const isMediumOrUpper = useMediaQuery((theme) => theme.breakpoints.up("md"));
  const [open, setOpen] = useSidebarState(isMediumOrUpper);
  const [adminOpen, setAdminOpen] = useState();
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("sm"));
  const { isLoading, identity } = useGetIdentity();
  const { permissions } = usePermissions();

  useEffect(() => {
    setOpen(isMediumOrUpper);
  }, [isMediumOrUpper, setOpen]);

  return (
    <Menu
      sx={{
        color: theme.palette.primary.main,
        marginTop: 0,
        borderRadius: isSmall ? 0 : 1,
        mr: 3,
        pt: 0.5,
        pb: 0.5,
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
        "& .SidebarAvatar": {
          pt: 1,
        },
        "&.RaMenu-open": {
          width: isSmall ? "100%" : "14rem",
          height: isSmall ? "100%" : "auto",
          ml: isSmall ? 0 : 1,
          p: isSmall ? 0 : "default",
          m: isSmall ? 0 : "default",
        },
        "&.RaMenu-closed": {
          ml: 0.5,
          width: "2.5rem",
          ".MuiMenuItem-root": {
            m: 0,
            padding: "0.25rem",
          },
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
      {!isLoading && open ? (
        <Grid
          container
          direction="column"
          alignItems="center"
          className="SidebarAvatar"
          mb={2}
        >
          <Grid item>
            <Gravatar email={identity.email} style={{ borderRadius: "50%" }} />
          </Grid>
          <Grid item>
            <Typography variant="h5" align="center">
              {identity.fullName}
            </Typography>
          </Grid>
        </Grid>
      ) : null}
      <Menu.DashboardItem />
      {open ? (
        <Typography variant="h4" pt={1}>
          Application mapping
        </Typography>
      ) : (
        <Divider />
      )}
      <MenuItem
        to="/application-mapping/by-app"
        primaryText="Applications"
        leftIcon={<WebAssetIcon />}
        permission="app-mapping"
      />
      <MenuItem
        to="/application-mapping/services-by-app"
        primaryText="Services par applications"
        leftIcon={<ShareIcon />}
        permission="service-mapping-per-app"
      />
      <MenuItem
        to="/application-mapping/by-hosting"
        primaryText="Hébergement"
        leftIcon={<LanIcon />}
        permission="service-mapping-per-host"
      />
      {open ? (
        <Typography variant="h4" pt={1}>
          Inventaire
        </Typography>
      ) : (
        <Divider />
      )}
      <MenuItem
        to="/applications"
        primaryText="Applications"
        leftIcon={<AppRegistrationIcon />}
        permission="view applications"
      />
      <MenuItem
        to="/service_instances"
        primaryText="Instances de services"
        leftIcon={<ViewModuleIcon />}
        permission="view service_instances"
      />
      <MenuItem
        to="/services"
        primaryText="Services"
        leftIcon={<WidgetsIcon />}
        permission="view services"
      />
      <MenuItem
        to="/hostings"
        primaryText="Hébergements"
        leftIcon={<SettingsSystemDaydreamIcon />}
        permission="view hostings"
      />
      {open && permissions.includes("admin") ? (
        <Typography
          variant="h4"
          pt={1}
          sx={{
            cursor: "pointer",
            ".MuiSvgIcon-root": {
              display: "inline-flex",
              verticalAlign: "middle",
            },
          }}
          onClick={() => setAdminOpen(!adminOpen)}
        >
          Administration{" "}
          {adminOpen ? <KeyboardArrowDownIcon /> : <KeyboardArrowUpIcon />}
        </Typography>
      ) : (
        <Divider />
      )}
      <Collapse in={adminOpen || !open}>
        <MenuItem
          to="/service_instance_dependencies"
          primaryText="Dépendances d'instances"
          leftIcon={<AccountTreeIcon />}
          permission="view service_instance_dependencies"
        />
        <MenuItem
          to="/environments"
          primaryText="Environments"
          leftIcon={<WindowIcon />}
          permission="view environments"
        />
        <MenuItem
          to="/service_versions"
          primaryText="Versions de service"
          leftIcon={<Replay30Icon />}
          permission="view service_versions"
        />
        <MenuItem
          to="/hosting_types"
          primaryText="Types d'hébergement"
          leftIcon={<StorageIcon />}
          permission="view hosting_types"
        />
        <MenuItem
          to="/teams"
          primaryText="Equipes"
          leftIcon={<GroupsIcon />}
          permission="view teams"
        />
        <MenuItem
          to="/users"
          primaryText="Utilisateurs"
          leftIcon={<PersonIcon />}
          permission="view users"
        />
        <MenuItem
          to="/roles"
          primaryText="Roles"
          leftIcon={<LocalOfferIcon />}
          permission="view roles"
        />
        <MenuItem
          to="/audits"
          primaryText="Audits"
          leftIcon={<HistoryIcon />}
          permission="view audits"
        />
      </Collapse>
    </Menu>
  );
};

const MenuItem = ({ permission, ...props }) => {
  const { permissions } = usePermissions();
  if (permission && !permissions?.includes(permission)) {
    return null;
  }
  return <Menu.Item {...props} />;
};

export default AppMenu;
