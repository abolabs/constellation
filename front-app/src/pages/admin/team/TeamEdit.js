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

import TeamDefaultSchema from './TeamDefaultSchema';

const TeamEdit = () => {
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Team</Typography>
      <Edit>
        <SimpleForm
          resolver={yupResolver(TeamDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <TextInput source="manager" fullWidth />
        </SimpleForm>
      </Edit>
    </>
  );
};

export default TeamEdit;
