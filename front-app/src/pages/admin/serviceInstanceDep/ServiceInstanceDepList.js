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
  useRecordContext,
} from "react-admin";
import { Chip, useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";
import ErrorIcon from '@mui/icons-material/Error';
import WarningIcon from '@mui/icons-material/Warning';
import InfoIcon from '@mui/icons-material/Info';

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultList from "@components/styled/DefaultList";

const serviceInstanceDepListFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
];

const ServiceInstanceDepList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service instance dependencies</Typography>
      <DefaultList
        {...props}
        filters={serviceInstanceDepListFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            primaryText={(record) => "#" + record.id + " - " + record.service_name}
            secondaryText={
              <TextField source="version" />
            }
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <TextField source="instance_application_name" label="Source app"/>
            <NumberField source="instance_id" />
            <TextField source="instance_service_name" />
            <TextField source="instance_dep_application_name" label="Dep app"/>
            <NumberField source="instance_dep_id" />
            <TextField source="instance_dep_service_name" />
            <LevelChip source="level" />
            <TextField source="level" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const LevelChip =  ({ source }) => {
  const record = useRecordContext();
  if (!record) return null;
  let color = null;
  let label = "Unknown";
  let icon = null;
  switch (record?.[source]) {
    case 1:
      color = "info";
      label = "Mineure";
      icon = <InfoIcon />;
      break;
    case 2:
      color = "warning";
      label = "Majeure";
      icon = <WarningIcon />;
      break;
    case 3:
      color = "error";
      label = "Critique";
      icon = <ErrorIcon />;
      break;
    default:
      break;
  }

  return <Chip icon={icon} label={label} color={color} />;
};

export default ServiceInstanceDepList;
