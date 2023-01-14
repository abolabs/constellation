import * as React from 'react';
import {
  Create,
  SimpleForm,
  TextInput,
} from "react-admin";
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from '@/components/toolbar/DefaultEditToolBar';
import EnvironmentDefaultSchema from './EnvironmentDefaultSchema';

const EnvironmentCreate = () => {
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Environment</Typography>
      <Create>
        <SimpleForm
          resolver={yupResolver(EnvironmentDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
        </SimpleForm>
      </Create>
    </>
  );
};

export default EnvironmentCreate;
