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
  ReferenceInput,
  SelectInput,
  useTranslate,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultList from "@components/styled/DefaultList";
import WithPermission from "@components/WithPermission";

import i18nProvider from "@providers/I18nProvider";

const auditFilters = [
  <TextInput label={i18nProvider.translate("ra.action.search")} source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    source="user_id"
    reference="users"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const AuditList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const t = useTranslate();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">{t('resources.audits.name')}</Typography>
      <DefaultList
        {...props}
        filters={auditFilters}
        actions={<DefaultToolBar canCreate={false}/>}
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) =>
              `#${record.id} - [${record.auditable_id}- ${record.auditable_type} ]`
            }
            secondaryText={<TextField source="user_name" />}
            tertiaryText={(record) =>
              `${record.event} - ${new Date(
                record.created_at
              ).toLocaleDateString()}`
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <NumberField source="id" />
            <TextField source="user_name" />
            <TextField source="auditable_id" />
            <TextField source="auditable_type" />
            <TextField source="event" />
            <TextField source="ip_address" />
            <DateField source="created_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const AuditListWithPermission = (props) => (
  <WithPermission
    permission="view audits"
    element={AuditList}
    elementProps={props}
  />
);

export default AuditListWithPermission;
