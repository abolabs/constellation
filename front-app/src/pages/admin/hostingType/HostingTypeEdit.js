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

import HostingTypeDefaultSchema from './HostingTypeDefaultSchema';

const HostingTypeEdit = () => {
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Hosting Type</Typography>
      <Edit>
        <SimpleForm
          resolver={yupResolver(HostingTypeDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <TextInput source="description" fullWidth />
        </SimpleForm>
      </Edit>
    </>
  );
};

export default HostingTypeEdit;
