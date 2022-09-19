
import { Menu } from 'react-admin';
import SubMenu from '@components/menu/SubMenu';

import AppRegistrationIcon from '@mui/icons-material/AppRegistration';
import ViewModuleIcon from '@mui/icons-material/ViewModule';
import WidgetsIcon from '@mui/icons-material/Widgets';
import SettingsSystemDaydreamIcon from '@mui/icons-material/SettingsSystemDaydream';
import ShareIcon from '@mui/icons-material/Share';
import SettingsIcon from '@mui/icons-material/Settings';
import WindowIcon from '@mui/icons-material/Window';
import AccountTreeIcon from '@mui/icons-material/AccountTree';
import StorageIcon from '@mui/icons-material/Storage';
import GroupsIcon from '@mui/icons-material/Groups';
import LocalOfferIcon from '@mui/icons-material/LocalOffer';
import PersonIcon from '@mui/icons-material/Person';

const AppMenu = () => (
  <Menu>
    <Menu.DashboardItem />
    <Menu.Item to="/applications" primaryText="Applications" leftIcon={<AppRegistrationIcon />} />
    <Menu.Item to="/service_instances" primaryText="Instances de services" leftIcon={<ViewModuleIcon />} />
    <Menu.Item to="/services" primaryText="Services" leftIcon={<WidgetsIcon />} />
    <Menu.Item to="/hostings" primaryText="Hébergements" leftIcon={<SettingsSystemDaydreamIcon />} />
    <SubMenu primaryText="Administration" leftIcon={<SettingsIcon />}>
      <Menu.Item to="/service_instance_dependencies" primaryText="Dépendances d'instances de service" leftIcon={<ShareIcon />} />
      <Menu.Item to="/environnements" primaryText="Environnements" leftIcon={<WindowIcon />} />
      <Menu.Item to="/service_versions" primaryText="Versions de service" leftIcon={<AccountTreeIcon />} />
      <Menu.Item to="/hosting_types" primaryText="Types d'hébergement" leftIcon={<StorageIcon />} />
      <Menu.Item to="/teams" primaryText="Equipes" leftIcon={<GroupsIcon />} />
      <Menu.Item to="/users" primaryText="Utilisateurs" leftIcon={<PersonIcon />} />
      <Menu.Item to="/roles" primaryText="Roles" leftIcon={<LocalOfferIcon />} />
    </SubMenu>
  </Menu>
);

export default AppMenu;
