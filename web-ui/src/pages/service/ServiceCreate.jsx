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
import {
  Create,
  SimpleForm,
  TextInput,
  ReferenceInput,
  AutocompleteInput,
  useTranslate,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import ServiceDefaultSchema from "./ServiceDefaultSchema";
import WithPermission from "@components/WithPermission";
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";

const ServiceCreate = () => {
  const location = useLocation();
  const t = useTranslate();

  const TeamOptionText = (data) => `#${data.id} - ${data.name}`;

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">{t("resources.services.name")}</Typography>
      <Create>
        <SimpleForm resolver={yupResolver(ServiceDefaultSchema)}>
          <TextInput source="name" fullWidth />
          <TextInput
            source="git_repo"
            fullWidth
            label={
              <OptionalFieldTitle
                label={t("resources.services.fields.git_repo")}
              />
            }
          />
          <ReferenceInput
            source="team_id"
            reference="teams"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput optionText={TeamOptionText} fullWidth />
          </ReferenceInput>
        </SimpleForm>
      </Create>
    </>
  );
};

const ServiceCreateWithPermission = () => (
  <WithPermission permission="create services" element={ServiceCreate} />
);

export default ServiceCreateWithPermission;
