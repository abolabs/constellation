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
import { useTheme } from "@mui/material/styles";
import Typography from "@mui/material/Typography";
import Divider from "@mui/material/Divider";
import { useMediaQuery } from "@mui/material";

const AppMenu = () => {
  const theme = useTheme();
  const [open] = useSidebarState();
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("sm"));

  return (
    <Menu
      sx={{
        marginTop: 0,
        background: theme.palette.secondary.dark,
        borderRadius: isSmall ? 0 : 1,
        mr: 3,
        pt: 0.5,
        pb:0.5,
        h4: {
          textAlign: "center",
          color: theme.palette.secondary.light,
          mt: 0.5,
          mb: 0.5,
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
        ".MuiSvgIcon-root": {
          background: theme.palette.background.paper,
          color: theme.palette.secondary.main,
          width: "2rem",
          height: "2rem",
          borderRadius: 1,
          mr: "1rem",
          p: 0.5,
          boxShadow: 1,
        },
        ".MuiMenuItem-root": {
          borderRadius: 1,
          m: "0.25rem 0",
          fontSize: "0.85rem",
          color: theme.palette.primary.contrastText,
        },
        ".MuiButtonBase-root": {
          ".MuiListItemIcon-root": {
            minWidth: 0,
          },
        },
        ".RaMenuItemLink-active": {
          boxShadow: theme.palette.shadows[1],
          color: theme.palette.primary.contrastText,
          ".MuiSvgIcon-root": {
            background: theme.palette.primary.main,
            color: theme.palette.secondary.contrastText,
          },
        },
      }}
    >
      <Menu.DashboardItem />
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
        <Typography variant="h4">Administration</Typography>
      ) : (
        <Divider />
      )}
      <Menu.Item
        to="/service_instance_dependencies"
        primaryText="Dépendances d'instances"
        leftIcon={<ShareIcon />}
      />
      <Menu.Item
        to="/environnements"
        primaryText="Environnements"
        leftIcon={<WindowIcon />}
      />
      <Menu.Item
        to="/service_versions"
        primaryText="Versions de service"
        leftIcon={<AccountTreeIcon />}
      />
      <Menu.Item
        to="/hosting_types"
        primaryText="Types d'hébergement"
        leftIcon={<StorageIcon />}
      />
      <Menu.Item to="/teams" primaryText="Equipes" leftIcon={<GroupsIcon />} />
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
    </Menu>
  );
};

export default AppMenu;
