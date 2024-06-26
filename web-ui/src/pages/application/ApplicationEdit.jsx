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
  AutocompleteInput,
  Edit,
  ReferenceInput,
  SimpleForm,
  TextInput,
  useTranslate,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultEditToolBar from "@components/toolbar/DefaultEditToolBar";
import ApplicationDefaultSchema from "./ApplicationDefaultSchema";
import WithPermission from "@components/WithPermission";

const ApplicationEdit = () => {
  const location = useLocation();
  const t = useTranslate();
  const TeamOptionText = (data) => `#${data.id} - ${data.name}`;

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t("resources.applications.name")}</Typography>
      <Edit redirect="show">
        <SimpleForm
          resolver={yupResolver(ApplicationDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <ReferenceInput
            source="team_id"
            reference="teams"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput optionText={TeamOptionText} fullWidth />
          </ReferenceInput>
        </SimpleForm>
      </Edit>
    </>
  );
};

const ApplicationEditWithPermission = () => (
  <WithPermission permission="edit applications" element={ApplicationEdit} />
);

export default ApplicationEditWithPermission;
