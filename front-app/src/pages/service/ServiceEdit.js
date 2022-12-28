import * as React from 'react';
import {
  AutocompleteInput,
  Edit,
  ReferenceInput,
  SimpleForm,
  TextInput,
} from "react-admin";
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";

const ServiceEdit = () => {
  const location = useLocation();

  const schema = yup.object()
    .shape({
        name: yup.string()
          .required('Please define a service name')
          .typeError('Please define a service name')
          .max(254),
        git_repo: yup.string()
          .required('Please define a git url')
          .typeError('Please define a git url')
          .url()
          .nullable()
          .max(254),
        team_id: yup.number()
          .required('Please select a team')
          .typeError('Please select a team')
    })
    .required();

  const TeamOptionText = (data) =>  `#${data.id} - ${data.name}`;

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service</Typography>
      <Edit>
        <SimpleForm resolver={yupResolver(schema)}>
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
