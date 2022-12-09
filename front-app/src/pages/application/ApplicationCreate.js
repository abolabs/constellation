import * as React from 'react';
import { Create, SimpleForm, TextInput, ReferenceInput, AutocompleteInput } from 'react-admin';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";

const ApplicationCreate = () => {
  const location = useLocation();

  const schema = yup.object()
    .shape({
        name: yup.string()
          .required('Please select a service')
          .typeError('Please select a service')
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
      <Typography variant="h3">Application</Typography>
      <Create>
          <SimpleForm resolver={yupResolver(schema)}>
              <TextInput source="name" fullWidth />
              <ReferenceInput source="team_id" reference="teams" sort={{field:"name", order:"ASC"}} >
                <AutocompleteInput label="Team" optionText={TeamOptionText} fullWidth/>
              </ReferenceInput>
          </SimpleForm>
      </Create>
    </>
  );
};

export default ApplicationCreate;
