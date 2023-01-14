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
import TeamDefaultSchema from './TeamDefaultSchema';

const TeamCreate = () => {
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Team</Typography>
      <Create>
        <SimpleForm
          resolver={yupResolver(TeamDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <TextInput source="manager" fullWidth />
        </SimpleForm>
      </Create>
    </>
  );
};

export default TeamCreate;
