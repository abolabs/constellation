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
  NumberField,
  TopToolbar,
  FilterButton,
  ExportButton,
  useTranslate,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultList from "@components/styled/DefaultList";
import LevelChip from "./LevelChip";
import WithPermission from "@components/WithPermission";

const serviceInstanceDepListFilters = [
  <TextInput key="search-filter" label="Search" source="q" alwaysOn variant="outlined" />,
];

const ServiceInstanceDepList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const t = useTranslate();

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">
        {t("resources.service_instance_dependencies.name")}
      </Typography>
      <DefaultList
        {...props}
        filters={serviceInstanceDepListFilters}
        actions={
          <TopToolbar>
            <FilterButton />
            <ExportButton />
          </TopToolbar>
        }
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) => {
              return (
                <>
                  <LevelChip source="level" />
                  &nbsp; #{record.instance_id} -{record.instance_service_name}{" "}
                  {t("needs")} #{record.instance_dep_id} -{" "}
                  {record.instance_dep_service_name}
                </>
              );
            }}
            secondaryText={<TextField source="instance_application_name" />}
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <TextField source="instance_application_name" />
            <NumberField source="instance_id" />
            <TextField source="instance_service_name" />
            <TextField source="instance_dep_application_name" />
            <NumberField source="instance_dep_id" />
            <TextField source="instance_dep_service_name" />
            <LevelChip source="level" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const ServiceInstanceDepListWithPermission = (props) => (
  <WithPermission
    permission="view service_instance_dependencies"
    element={ServiceInstanceDepList}
    elementProps={props}
  />
);

export default ServiceInstanceDepListWithPermission;
