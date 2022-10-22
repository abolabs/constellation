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

const AppMenu = () => {
  const theme = useTheme();
  const [open] = useSidebarState();

  return (
    <Menu
      sx={{
        marginTop: 0,
        h3: {
          textAlign: "center",
          color: theme.palette.secondary.main,
          mt: 1,
          mb: 1,
        },
        "&.RaMenu-closed": {
          opacity: 0.8,
          ".MuiMenuItem-root": {
            m: 0,
          },
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
          m: "0.25rem 1rem",
          fontSize: "0.85rem",
        },
        ".MuiButtonBase-root": {
          ".MuiListItemIcon-root": {
            minWidth: 0,
          },
        },
        ".RaMenuItemLink-active": {
          boxShadow: theme.palette.shadows[1],
          ".MuiSvgIcon-root": {
            background: theme.palette.primary.main,
            color: theme.palette.secondary.contrastText,
          },
        },
        ".MuiListItem-button": {
          ml: "1rem",
          ".MuiListItemText-root": {
            pl: 0,
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
        <Typography variant="h3">Administration</Typography>
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
