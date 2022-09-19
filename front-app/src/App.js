// in src/App.js
import * as React from "react";
import { Admin, Resource, ListGuesser, Title } from 'react-admin';
import apiClient from "ra-laravel-client";
import AuthProvider from '@providers/AuthProvider';
import LoginPage from '@pages/LoginPage';
import ApplicationList from '@pages/application/ApplicationList';
import AppTheme from "@themes/AppTheme";
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import AppLayout from "@layouts/AppLayout";

const dataProvider = apiClient('http://localhost:8080/api/v1',
  {
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Content-Type': 'application/json',
    },
    offsetPageNum: 0
  },
  "auth");

// @todo : créer composant à part pour le dashboard
const Dashboard = () => {
  return (
    <Card>
      <Title title="Welcome to Constellation" />
      <CardContent>Lorem ipsum sic dolor amet...</CardContent>
    </Card>
  )
};

const App = () => (
  <Admin layout={AppLayout}
    theme={AppTheme}
    title="Constellation"
    dashboard={Dashboard}
    loginPage={LoginPage}
    authProvider={AuthProvider}
    dataProvider={dataProvider}
    disableTelemetry
  >
    <Resource name="applications" list={ApplicationList} />
    <Resource name="service_instances" list={ListGuesser} />
    <Resource name="services" list={ListGuesser} />
    <Resource name="hostings" list={ListGuesser} />
    <Resource name="service_instance_dependencies" list={ListGuesser} />
    <Resource name="environnements" list={ListGuesser} />
    <Resource name="service_versions" list={ListGuesser} />
    <Resource name="hosting_types" list={ListGuesser} />
    <Resource name="teams" list={ListGuesser} />
    <Resource name="users" list={ListGuesser} />
    <Resource name="roles" list={ListGuesser} />
  </Admin>
);


export default App;
