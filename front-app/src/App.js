// in src/App.js
import * as React from "react";
import { Admin, Resource, ListGuesser, Title, ShowGuesser, EditGuesser } from "react-admin";
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
          list={ListGuesser}
          edit={EditGuesser}
          show={ShowGuesser}
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
        <Resource name="service_instance_dependencies" list={ListGuesser} />
        <Resource name="environnements" list={ListGuesser} />
        <Resource name="service_versions" list={ListGuesser} />
        <Resource name="hosting_types"
          list={HostingTypeList}
          show={HostingTypeShow}
          create={HostingTypeCreate}
          edit={HostingTypeEdit}
        />
        <Resource name="teams"
          list={TeamList}
        />
        <Resource name="users" list={ListGuesser} />
        <Resource name="roles" list={ListGuesser} />
      </Admin>
    </ColorModeContext.Provider>
  );
};

export default App;
