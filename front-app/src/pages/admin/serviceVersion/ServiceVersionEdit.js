import * as React from 'react';
import {
  Edit,
  SimpleForm,
  TextInput,
} from "react-admin";
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from '@/components/toolbar/DefaultEditToolBar';

import ServiceVersionDefaultSchema from './ServiceVersionDefaultSchema';

const ServiceVersionEdit = () => {
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service Version</Typography>
      <Edit>
        <SimpleForm
          resolver={yupResolver(ServiceVersionDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="version" fullWidth />
        </SimpleForm>
      </Edit>
    </>
  );
};

export default ServiceVersionEdit;
