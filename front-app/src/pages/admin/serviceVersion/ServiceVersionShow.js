import { DateField, LinearProgress, Show, TextField, useShowController } from "react-admin";
import { useLocation } from "react-router-dom";
import {
  Box,
  Typography
} from "@mui/material";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";

const ServiceVersionShow = () => {
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
      <Typography variant="h3">Service Version</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout title={record?.service_name}>
            <TextField source="id" />
            <TextField source="version" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

export default ServiceVersionShow;
