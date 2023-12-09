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

import {
  Datagrid,
  ReferenceField,
  SimpleList,
  TextField,
  TextInput,
  ReferenceInput,
  SelectInput,
  BulkExportButton,
  BooleanField,
  useTranslate,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import DefaultList from "@components/styled/DefaultList";
import WithPermission from "@components/WithPermission";
import i18nProvider from "@providers/I18nProvider";

const servicesInstancesFilters = [
  <TextInput
    label={i18nProvider.translate("ra.action.search")}
    source="q"
    alwaysOn
    variant="outlined"
  />,
  <ReferenceInput
    key="hosting_filter"
    source="hosting_id"
    reference="hostings"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
  <ReferenceInput
    key="env_filter"
    source="environment_id"
    reference="environments"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const ServiceInstanceList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const t = useTranslate();

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">
        {t("resources.service_instances.name")}
      </Typography>
      <DefaultList
        {...props}
        filters={servicesInstancesFilters}
        actions={<DefaultToolBar canCreate={false} />}
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) =>
              "#" + record.id + " - " + record.application_name
            }
            secondaryText={
              <ReferenceField
                source="service_version_id"
                reference="service_versions"
                link={false}
              >
                <TextField source="version" />
              </ReferenceField>
            }
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <TextField source="application_name" />
            <TextField source="service_name" />
            <TextField source="service_version" />
            <TextField source="environment_name" />
            <TextField source="hosting_name" />
            <TextField source="role" />
            <BooleanField source="statut" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const ServiceInstanceListWithPermission = (props) => (
  <WithPermission
    permission="view service_instances"
    element={ServiceInstanceList}
    elementProps={props}
  />
);

export default ServiceInstanceListWithPermission;
