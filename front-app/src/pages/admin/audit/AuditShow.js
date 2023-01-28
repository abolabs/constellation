import { DateField, LinearProgress, NumberField, Show, TextField, UrlField, useShowController } from "react-admin";
import { JsonField } from "react-admin-json-view";
import { useLocation } from "react-router-dom";
import {
  Box,
  Typography
} from "@mui/material";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";

const AuditShow = () => {
  const location = useLocation();
  const { error, isLoading, record } = useShowController();

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
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Audit</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout title={record?.auditable_type} canDelete={false} canEdit={false}>
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
              jsonString={true} // Set to true if the value is a string, default: false
              reactJsonOptions={{
                // Props passed to react-json-view
                collapsed: true,
                enableClipboard: false,
                displayDataTypes: false,
                theme: 'ocean',
              }}
            />
            <JsonField
              source="new_values"
              jsonString={true} // Set to true if the value is a string, default: false
              reactJsonOptions={{
                // Props passed to react-json-view
                collapsed: true,
                enableClipboard: false,
                displayDataTypes: false,
                theme: 'ocean',
              }}
            />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

export default AuditShow;
