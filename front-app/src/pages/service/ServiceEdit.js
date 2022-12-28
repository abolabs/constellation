import * as React from 'react';
import {
  AutocompleteInput,
  Edit,
  ReferenceInput,
  SimpleForm,
  TextInput,
} from "react-admin";
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import ServiceDefaultSchema from './ServiceDefaultSchema';

const ServiceEdit = () => {
  const location = useLocation();

  const TeamOptionText = (data) =>  `#${data.id} - ${data.name}`;

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service</Typography>
      <Edit>
        <SimpleForm resolver={yupResolver(ServiceDefaultSchema)}>
          <TextInput source="name" fullWidth />
          <TextInput source="git_repo" fullWidth />
          <ReferenceInput
            source="team_id"
            reference="teams"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput
              label="Team"
              optionText={TeamOptionText}
              fullWidth
            />
          </ReferenceInput>
        </SimpleForm>
      </Edit>
    </>
  );
};

export default ServiceEdit;
