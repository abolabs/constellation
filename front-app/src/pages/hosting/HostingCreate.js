import * as React from 'react';
import {
  AutocompleteInput,
  Create,
  ReferenceInput,
  SimpleForm,
  TextInput,
} from "react-admin";
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from '@/components/toolbar/DefaultEditToolBar';
import HostingDefaultSchema from './HostingDefaultSchema';
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";

const HostingCreate = () => {
  const location = useLocation();

  const HostingTypeOptionText = (data) =>  `#${data.id} - ${data.name}`;

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Hosting</Typography>
      <Create>
        <SimpleForm
          resolver={yupResolver(HostingDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <ReferenceInput
            source="hosting_type_id"
            reference="hosting_types"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput
              label="Hosting type"
              optionText={HostingTypeOptionText}
              fullWidth
            />
          </ReferenceInput>
          <TextInput source="localisation" label={<OptionalFieldTitle label="Localisation" />} fullWidth />
        </SimpleForm>
      </Create>
    </>
  );
};

export default HostingCreate;
