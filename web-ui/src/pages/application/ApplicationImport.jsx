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

import React, { useState } from "react";
import {
  Create,
  SimpleForm,
  TextInput,
  ReferenceInput,
  AutocompleteInput,
  useTranslate,
  FileInput,
  BooleanInput,
  FileField,
  useCreate,
  useNotify,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation, useNavigate } from "react-router-dom";
import Typography from "@mui/material/Typography";
import * as yup from "yup";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import WithPermission from "@components/WithPermission";
import i18nProvider from "@providers/I18nProvider";
import AlertError from "@components/alerts/AlertError";
import { convertFileToBase64 } from "@providers/LaravelDataProvider/helpers";

const ApplicationImport = () => {
  const location = useLocation();
  const t = useTranslate();
  const navigate = useNavigate();
  const optionText = (data) => `#${data.id} - ${data.name}`;
  const [create, { isLoading }] = useCreate();
  const notify = useNotify();
  const [lastError, setLastError] = useState();

  if (isLoading) {
    return null;
  }

  const ApplicationDefaultSchema = yup
    .object()
    .shape({
      name: yup
        .string()
        .required(i18nProvider.translate("Please select a service"))
        .typeError(i18nProvider.translate("Please select a service"))
        .max(254),
      team_id: yup
        .number()
        .required(i18nProvider.translate("Please select a team"))
        .typeError(i18nProvider.translate("Please select a team")),
      environment_id: yup
        .number()
        .required(i18nProvider.translate("Please select an environment"))
        .typeError(i18nProvider.translate("Please select an environment")),
      hosting_id: yup
        .number()
        .required(i18nProvider.translate("Please select an hosting"))
        .typeError(i18nProvider.translate("Please select an hosting")),
      default_service_status: yup.boolean().required(),
      //stack_file: yup.mixed().required(),
    })
    .required();

  const handleSubmit = async (data) => {
    if (data?.stack_file?.rawFile instanceof File) {
      data.stack_file = await convertFileToBase64(data?.stack_file);
    }
    try {
      await create(
        "applications/import",
        { data: data },
        { returnPromise: true }
      );
      onSuccess();
      setLastError(null);
    } catch (error) {
      setLastError(error);
      console.error(error);
    }
  };

  const onSuccess = (_data) => {
    notify("Application imported", { type: "success" });
    return navigate("/applications");
  };

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t("resources.applications.name")}</Typography>
      <Create resource="applications/import">
        {lastError ? <AlertError {...lastError} /> : null}
        <SimpleForm
          resolver={yupResolver(ApplicationDefaultSchema)}
          onSubmit={handleSubmit}
        >
          <TextInput source="name" fullWidth />
          <ReferenceInput
            source="team_id"
            reference="teams"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput optionText={optionText} fullWidth />
          </ReferenceInput>
          <ReferenceInput
            source="environment_id"
            reference="environments"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput optionText={optionText} fullWidth />
          </ReferenceInput>
          <ReferenceInput
            source="hosting_id"
            reference="hostings"
            sort={{ field: "name", order: "ASC" }}
          >
            <AutocompleteInput optionText={optionText} fullWidth />
          </ReferenceInput>
          <BooleanInput
            label="Default service status"
            source="default_service_status"
            defaultValue={true}
          />
          <FileInput source="stack_file" label="docker-compose file">
            <FileField source="src" title="title" />
          </FileInput>
        </SimpleForm>
      </Create>
    </>
  );
};

const ApplicationImportWithPermission = () => (
  <WithPermission
    permission={[
      "create applications",
      "create services",
      "create service_instances",
      "create service_versions",
    ]}
    element={ApplicationImport}
  />
);

export default ApplicationImportWithPermission;
