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

import * as React from "react";
import { Admin, Resource, ListGuesser, Title, EditGuesser } from "react-admin";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";

import { responsiveFontSizes, createTheme } from "@mui/material/styles";
import CssBaseline from "@mui/material/CssBaseline";

import LightTheme from "@themes/LightTheme";
import DarkTheme from "@themes/DarkTheme";
import ColorModeContext from "@contexts/ColorModeContext";

import AuthProvider from "@providers/AuthProvider";
import dataProvider from "@providers/DataProvider";

import AppLayout from "@layouts/AppLayout";

import LoginPage from "@pages/LoginPage";
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
import HostingTypeList from "@pages/admin/hostingType/HostingTypeList";
import HostingTypeCreate from "@pages/admin/hostingType/HostingTypeCreate";
import HostingTypeShow from "@pages/admin/hostingType/HostingTypeShow";
import HostingTypeEdit from "@pages/admin/hostingType/HostingTypeEdit";
import TeamList from "@pages/admin/team/TeamList";
import TeamEdit from "@pages/admin/team/TeamEdit";
import TeamCreate from "@pages/admin/team/TeamCreate";
import TeamShow from "@pages/admin/team/TeamShow";
import EnvironmentList from "@pages/admin/environment/EnvironmentList";
import EnvironmentShow from "@pages/admin/environment/EnvironmentShow";
import EnvironmentCreate from "@pages/admin/environment/EnvironmentCreate";
import EnvironmentEdit from "@pages/admin/environment/EnvironmentEdit";
import ServiceVersionList from "@pages/admin/serviceVersion/ServiceVersionList";
import ServiceVersionShow from "@pages/admin/serviceVersion/ServiceVersionShow";
import AuditList from "@pages/admin/audit/AuditList";
import AuditShow from "@pages/admin/audit/AuditShow";
import ServiceVersionEdit from "@pages/admin/serviceVersion/ServiceVersionEdit";
import ServiceInstanceList from "@pages/serviceInstance/ServiceInstanceList";
import ServiceInstanceShow from "@pages/serviceInstance/ServiceInstanceShow";

// @todo : créer composant à part pour le dashboard
const Dashboard = () => {
  return (
    <Card>
      <Title title="Welcome to Constellation" />
      <CardContent>Lorem ipsum sic dolor amet...</CardContent>
    </Card>
  );
};

const App = () => {
  const defaultMode = React.useMemo(() => localStorage.getItem('themeMode') ?? "light", [ ]);
  const [mode, setMode] = React.useState(defaultMode);
  const colorMode = React.useMemo(
    () => ({
      // The dark mode switch would invoke this method
      toggleColorMode: () => {
        setMode((prevMode) => {
          let nextMode = "light";
          if (prevMode === "light") {
            nextMode = "dark";
          }
          localStorage.setItem('themeMode', nextMode);
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
      <Admin
        layout={AppLayout}
        title="Constellation"
        theme={responsiveFontSizes(theme)}
        dashboard={Dashboard}
        loginPage={LoginPage}
        authProvider={AuthProvider}
        dataProvider={dataProvider}
        disableTelemetry
      >
        <Resource name="applications"
          list={ApplicationList}
          show={ApplicationShow}
          create={ApplicationCreate}
          edit={ApplicationEdit}
        />
        <Resource name="service_instances"
          list={ServiceInstanceList}
          edit={EditGuesser}
          show={ServiceInstanceShow}
        />
        <Resource name="services"
          list={ServiceList}
          show={ServiceShow}
          create={ServiceCreate}
          edit={ServiceEdit}
        />
        <Resource name="hostings"
          list={HostingList}
          show={HostingShow}
          create={HostingCreate}
          edit={HostingEdit}
        />
        <Resource
          name="service_instance_dependencies"
          list={ListGuesser}
        />
        <Resource name="environnements"
          list={EnvironmentList}
          show={EnvironmentShow}
          create={EnvironmentCreate}
          edit={EnvironmentEdit}
        />
        <Resource name="service_versions"
          list={ServiceVersionList}
          show={ServiceVersionShow}
          edit={ServiceVersionEdit}
        />
        <Resource name="hosting_types"
          list={HostingTypeList}
          show={HostingTypeShow}
          create={HostingTypeCreate}
          edit={HostingTypeEdit}
        />
        <Resource name="teams"
          list={TeamList}
          show={TeamShow}
          create={TeamCreate}
          edit={TeamEdit}
        />
        <Resource name="users" list={ListGuesser} />
        <Resource name="roles" list={ListGuesser} />
        <Resource name="audits"
          list={AuditList}
          show={AuditShow}
        />
      </Admin>
    </ColorModeContext.Provider>
  );
};

export default App;
