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
  Create,
  ReferenceInput,
  SimpleForm,
  TextInput,
  useTranslate,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultEditToolBar from "@/components/toolbar/DefaultEditToolBar";
import HostingDefaultSchema from "./HostingDefaultSchema";
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";
import WithPermission from "@components/WithPermission";

const HostingCreate = () => {
  const location = useLocation();
  const t = useTranslate();
  const HostingTypeOptionText = (data) => `#${data.id} - ${data.name}`;

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t("resources.hostings.name")}</Typography>
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
            <AutocompleteInput optionText={HostingTypeOptionText} fullWidth />
          </ReferenceInput>
          <TextInput
            source="localisation"
            label={
              <OptionalFieldTitle
                label={t("resources.hostings.fields.localisation")}
              />
            }
            fullWidth
          />
        </SimpleForm>
      </Create>
    </>
  );
};

const HostingCreateWithPermission = () => (
  <WithPermission permission="create hostings" element={HostingCreate} />
);

export default HostingCreateWithPermission;
