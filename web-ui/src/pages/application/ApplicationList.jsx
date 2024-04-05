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
  ReferenceField,
  SimpleList,
  TextField,
  TextInput,
  ReferenceInput,
  SelectInput,
  BulkExportButton,
  usePermissions,
  useTranslate,
  downloadCSV,
} from "react-admin";
import { Button, useMediaQuery } from "@mui/material";
import { Link, useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";
import UploadFileIcon from "@mui/icons-material/UploadFile";
import { unparse as convertToCSV } from 'papaparse/papaparse.min';

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import DefaultList from "@components/styled/DefaultList";
import WithPermission from "@components/WithPermission";
import i18nProvider from "@providers/I18nProvider";

const applicationFilters = [
  <TextInput
    label={i18nProvider.translate("ra.action.search")}
    source="q"
    alwaysOn
    variant="outlined"
  />,
  <ReferenceInput
    label="Team"
    source="team_id"
    reference="teams"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const applicationExporter = (records, fetchRelatedRecords) => {
  fetchRelatedRecords(records, 'team_id', 'teams').then((teams) => {
    const data = records.map(record => {
      return {
        ...record,
        team_name: teams[record.team_id].name,
      }
    });
    const csv = convertToCSV({
      data,
      fields: ['id', 'name', 'team_name', 'created_at', 'updated_at'],
    });
    downloadCSV(csv, `applications_${Date.now()}`);
  });
};

const ApplicationList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const { permissions } = usePermissions();
  const t = useTranslate();

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t("resources.applications.name")}</Typography>
      <DefaultList
        {...props}
        exporter={applicationExporter}
        filters={applicationFilters}
        actions={
          <DefaultToolBar
            canCreate={permissions.includes("create applications")}
          >
            {permissions?.includes("create applications") && permissions?.includes("create services")
              ?
              <Link to="/applications/import">
                <Button
                  startIcon={<UploadFileIcon />}
                  variant="text"
                  size="small"
                  sx={{ lineHeight: "inherit" }}
                >
                  {t("ra.action.import")}
                </Button>
              </Link>
              : null
            }
          </DefaultToolBar>
        }
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) => "#" + record.id + " - " + record.name}
            secondaryText={
              <ReferenceField source="team_id" reference="teams" link={false}>
                <TextField source="name" />
              </ReferenceField>
            }
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <TextField source="name" />
            {permissions.includes("view teams") ? (
              <ReferenceField source="team_id" reference="teams" link={false}>
                <TextField source="name" />
              </ReferenceField>
            ) : null}
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const ApplicationListWithPermission = (props) => (
  <WithPermission
    permission="view applications"
    element={ApplicationList}
    elementProps={props}
  />
);

export default ApplicationListWithPermission;
