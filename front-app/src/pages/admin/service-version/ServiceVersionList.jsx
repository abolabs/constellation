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
  DateField,
  SimpleList,
  TextField,
  TextInput,
  BulkExportButton,
  ReferenceField,
  ReferenceInput,
  SelectInput,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultList from "@components/styled/DefaultList";
import WithPermission from "@components/WithPermission";

const serviceVersionFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    label="Service"
    source="service_id"
    reference="services"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const ServiceVersionList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service Version</Typography>
      <DefaultList
        {...props}
        filters={serviceVersionFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) =>
              "#" + record.id + " - " + record.service_name
            }
            secondaryText={<TextField source="version" />}
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <ReferenceField source="service_id" reference="services">
              <TextField source="name" />
            </ReferenceField>
            <TextField source="version" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const ServiceVersionListWithPermission = (props) => (
  <WithPermission
    permission="view service_versions"
    element={ServiceVersionList}
    elementProps={props}
  />
);

export default ServiceVersionListWithPermission;
