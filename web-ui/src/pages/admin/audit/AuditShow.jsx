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
  DateField,
  LinearProgress,
  NumberField,
  Show,
  TextField,
  UrlField,
  useShowController,
  useTranslate,
} from "react-admin";
import { JsonField } from "react-admin-json-view";
import { useLocation } from "react-router-dom";
import { Box, Typography } from "@mui/material";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";
import WithPermission from "@components/WithPermission";

const AuditShow = () => {
  const location = useLocation();
  const { error, isLoading, record } = useShowController();
  const t = useTranslate();

  if (isLoading) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (error) {
    return <AlertError error={error} />;
  }

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t('resources.audits.name')}</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout
          title={record?.auditable_type}
          canDelete={false}
          canEdit={false}
        >
          <NumberField source="id" />
          <TextField source="user_type" />
          <NumberField source="user_id" />
          <TextField source="user_name" />
          <TextField source="event" />
          <TextField source="auditable_type" />
          <NumberField source="auditable_id" />
          <UrlField source="url" />
          <TextField source="ip_address" />
          <TextField source="user_agent" />
          <TextField source="tags" />
          <DateField source="created_at" />
          <DateField source="updated_at" />
          <JsonField
            source="old_values"
            reactJsonOptions={{
              // Props passed to react-json-view
              collapsed: true,
              enableClipboard: false,
              displayDataTypes: false,
              theme: "ocean",
            }}
          />
          <JsonField
            source="new_values"
            reactJsonOptions={{
              // Props passed to react-json-view
              collapsed: true,
              enableClipboard: false,
              displayDataTypes: false,
              theme: "ocean",
            }}
          />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

const AuditShowWithPermission = () => (
  <WithPermission permission="view audits" element={AuditShow} />
);

export default AuditShowWithPermission;
