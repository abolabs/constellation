// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

import * as React from "react";
import { Box, LinearProgress, Link, Typography } from "@mui/material";
import {
  AutocompleteInput,
  BooleanInput,
  Edit,
  ReferenceInput,
  SimpleForm,
  TextInput,
  useShowController,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from "@components/toolbar/DefaultEditToolBar";
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";
import AlertError from "@components/alerts/AlertError";

import ServiceInstanceDefaultSchema from "./ServiceInstanceDefaultSchema";
import ServiceVersionInput from "./ServiceVersionInput";

const ServiceInstanceEdit = () => {
  const location = useLocation();
  const { error, isLoading, record } = useShowController();

  const ApplicationOptionText = (data) => `#${data.id} - ${data.name}`;
  const hostingOptionText = (data) => `#${data.id} - ${data.name}`;

  if (isLoading) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (error) {
    return <AlertError error={error} />;
  }

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography
        variant="h3"
        sx={{
          mb: 2,
        }}
      >
        <Link href={`/applications/${record?.application_id}/show`}>
          {record?.application_name}
        </Link>{" "}
        /{" "}
        <Link href={`/service_instances/${record?.id}/show`}>
          {record?.service_name}
        </Link>
      </Typography>
      <Edit redirect="show" mutationMode="pessimistic">
        <SimpleForm
          resolver={yupResolver(ServiceInstanceDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <ReferenceInput
            source="application_id"
            reference="applications"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput
              label="Application"
              optionText={ApplicationOptionText}
              fullWidth
            />
          </ReferenceInput>

          <ServiceVersionInput />

          <ReferenceInput
            source="environment_id"
            reference="environments"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput
              label="Environment"
              optionText="name"
              fullWidth
            />
          </ReferenceInput>

          <ReferenceInput
            source="hosting_id"
            reference="hostings"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput
              label="Hébergement"
              optionText={hostingOptionText}
              fullWidth
            />
          </ReferenceInput>

          <TextInput
            source="url"
            label={<OptionalFieldTitle label="Url" />}
            fullWidth
          />

          <TextInput
            source="role"
            label={<OptionalFieldTitle label="Role" />}
            fullWidth
          />

          <BooleanInput label="Statut" source="statut" defaultValue={true} />
        </SimpleForm>
      </Edit>
    </>
  );
};

export default ServiceInstanceEdit;
