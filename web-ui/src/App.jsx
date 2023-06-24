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

// Librairies
import * as React from "react";
import { BrowserRouter, Navigate, Route, Routes } from "react-router-dom";
import { Admin, Authenticated, CustomRoutes, Resource } from "react-admin";
import { responsiveFontSizes, createTheme } from "@mui/material/styles";
import CssBaseline from "@mui/material/CssBaseline";

// Providers
import authProvider from "@providers/AuthProvider";
import dataProvider from "@providers/DataProvider";
import i18nProvider from "@providers/I18nProvider";

// Theme
import LightTheme from "@themes/LightTheme";
import DarkTheme from "@themes/DarkTheme";
import ColorModeContext from "@contexts/ColorModeContext";

// Layout
import AppLayout from "@layouts/AppLayout";

// Pages
import LoginPage from "@pages/auth/LoginPage";
import ApplicationList from "@pages/application/ApplicationList";
import ApplicationShow from "@pages/application/ApplicationShow";
import ApplicationCreate from "@pages/application/ApplicationCreate";
import ApplicationEdit from "@pages/application/ApplicationEdit";
import ServiceList from "@pages/service/ServiceList";
import ServiceShow from "@pages/service/ServiceShow";
import ServiceEdit from "@pages/service/ServiceEdit";
import ServiceCreate from "@pages/service/ServiceCreate";
import HostingList from "@pages/hosting/HostingList";
import HostingShow from "@pages/hosting/HostingShow";
import HostingEdit from "@pages/hosting/HostingEdit";
import HostingCreate from "@pages/hosting/HostingCreate";
import HostingTypeList from "@pages/admin/hosting-type/HostingTypeList";
import HostingTypeCreate from "@pages/admin/hosting-type/HostingTypeCreate";
import HostingTypeShow from "@pages/admin/hosting-type/HostingTypeShow";
import HostingTypeEdit from "@pages/admin/hosting-type/HostingTypeEdit";
import TeamList from "@pages/admin/team/TeamList";
import TeamEdit from "@pages/admin/team/TeamEdit";
import TeamCreate from "@pages/admin/team/TeamCreate";
import TeamShow from "@pages/admin/team/TeamShow";
import EnvironmentList from "@pages/admin/environment/EnvironmentList";
import EnvironmentShow from "@pages/admin/environment/EnvironmentShow";
import EnvironmentCreate from "@pages/admin/environment/EnvironmentCreate";
import EnvironmentEdit from "@pages/admin/environment/EnvironmentEdit";
import ServiceVersionList from "@pages/admin/service-version/ServiceVersionList";
import ServiceVersionShow from "@pages/admin/service-version/ServiceVersionShow";
import ServiceVersionEdit from "@pages/admin/service-version/ServiceVersionEdit";
import AuditList from "@pages/admin/audit/AuditList";
import AuditShow from "@pages/admin/audit/AuditShow";
import ServiceInstanceList from "@pages/service-instance/ServiceInstanceList";
import ServiceInstanceShow from "@pages/service-instance/ServiceInstanceShow";
import ServiceInstanceEdit from "@pages/service-instance/ServiceInstanceEdit";
import UserList from "@pages/admin/user/UserList";
import UserShow from "@pages/admin/user/UserShow";
import UserCreate from "@pages/admin/user/UserCreate";
import UserEdit from "@pages/admin/user/UserEdit";
import RoleList from "@pages/admin/role/RoleList";
import RoleShow from "@pages/admin/role/RoleShow";
import RoleCreate from "@pages/admin/role/RoleCreate";
import RoleEdit from "@pages/admin/role/RoleEdit";
import ServiceInstanceDepList from "@pages/admin/service-instance-dep/ServiceInstanceDepList";
import ServiceInstanceDepShow from "@pages/admin/service-instance-dep/ServiceInstanceDepShow";
import MappingByApp from "@pages/application-mapping/MappingByApp";
import MappingServicesByApp from "@pages/application-mapping/MappingServicesByApp";
import MappingByHosting from "@pages/application-mapping/MappingByHosting";
import AccountEdit from "@pages/account/AccountEdit";
import ResetPasswordRequest from "@pages/auth/ResetPasswordRequest";
import ResetPasswordForm from "@pages/auth/ResetPasswordForm";
import Dashboard from "@pages/dashboard/Dashboard";

const App = () => {
  const defaultMode = React.useMemo(
    () => localStorage.getItem("themeMode") ?? "light",
    []
  );
  const [mode, setMode] = React.useState(defaultMode);
  const colorMode = React.useMemo(
    () => ({
      // The dark mode switch would invoke this method
      toggleColorMode: () => {
        setMode((prevMode) => {
          let nextMode = "dark";
          if (prevMode === "dark" || !prevMode) {
            nextMode = "light";
          }
          localStorage.setItem("themeMode", nextMode);
          return nextMode;
        });
      },
    }),
    []
  );

  const getDesignTokens = (mode) => {
    const themes = {
      light: LightTheme,
      dark: DarkTheme,
    };
    return themes[mode];
  };

  const theme = React.useMemo(() => createTheme(getDesignTokens(mode)), [mode]);

  return (
    <ColorModeContext.Provider value={colorMode}>
      <CssBaseline />
      <BrowserRouter>
        <Routes>
          <Route
            path="/public/password-reset-request"
            element={<ResetPasswordRequest />}
          />
          <Route
            path="/public/reset-password"
            element={<ResetPasswordForm />}
          />
          <Route
            path="/*"
            element={
              <Admin
                layout={AppLayout}
                title="Constellation"
                theme={responsiveFontSizes(theme)}
                dashboard={Dashboard}
                loginPage={LoginPage}
                authProvider={authProvider}
                dataProvider={dataProvider}
                i18nProvider={i18nProvider}
                disableTelemetry
                requireAuth
              >
                <CustomRoutes>
                  <Route
                    path="/application-mapping/by-app"
                    element={
                      <Authenticated>
                        <MappingByApp />
                      </Authenticated>
                    }
                  />
                  <Route
                    path="/application-mapping/services-by-app"
                    element={
                      <Authenticated>
                        <MappingServicesByApp />
                      </Authenticated>
                    }
                  />
                  <Route
                    path="/application-mapping/by-hosting"
                    element={
                      <Authenticated>
                        <MappingByHosting />
                      </Authenticated>
                    }
                  />
                  <Route
                    path="/application-mapping/*"
                    element={<Navigate to="/application-mapping/by-app" />}
                  />
                  <Route
                    path="/account/edit"
                    element={
                      <Authenticated>
                        <AccountEdit />
                      </Authenticated>
                    }
                  />
                  <Route
                    path="/account/*"
                    element={<Navigate to="/account/edit" />}
                  />
                </CustomRoutes>
                <Resource
                  name="applications"
                  list={ApplicationList}
                  show={ApplicationShow}
                  create={ApplicationCreate}
                  edit={ApplicationEdit}
                />
                <Resource
                  name="service_instances"
                  list={ServiceInstanceList}
                  edit={ServiceInstanceEdit}
                  show={ServiceInstanceShow}
                />
                <Resource
                  name="services"
                  list={ServiceList}
                  show={ServiceShow}
                  create={ServiceCreate}
                  edit={ServiceEdit}
                />
                <Resource
                  name="hostings"
                  list={HostingList}
                  show={HostingShow}
                  create={HostingCreate}
                  edit={HostingEdit}
                />
                <Resource
                  name="service_instance_dependencies"
                  list={ServiceInstanceDepList}
                  show={ServiceInstanceDepShow}
                />
                <Resource
                  name="environments"
                  list={EnvironmentList}
                  show={EnvironmentShow}
                  create={EnvironmentCreate}
                  edit={EnvironmentEdit}
                />
                <Resource
                  name="service_versions"
                  list={ServiceVersionList}
                  show={ServiceVersionShow}
                  edit={ServiceVersionEdit}
                />
                <Resource
                  name="hosting_types"
                  list={HostingTypeList}
                  show={HostingTypeShow}
                  create={HostingTypeCreate}
                  edit={HostingTypeEdit}
                />
                <Resource
                  name="teams"
                  list={TeamList}
                  show={TeamShow}
                  create={TeamCreate}
                  edit={TeamEdit}
                />
                <Resource
                  name="users"
                  list={UserList}
                  show={UserShow}
                  create={UserCreate}
                  edit={UserEdit}
                />
                <Resource
                  name="roles"
                  list={RoleList}
                  show={RoleShow}
                  create={RoleCreate}
                  edit={RoleEdit}
                />
                <Resource name="audits" list={AuditList} show={AuditShow} />
              </Admin>
            }
          />
          <Route path="/*" element={<Navigate to="/login" />} />
        </Routes>
      </BrowserRouter>
    </ColorModeContext.Provider>
  );
};

export default App;
