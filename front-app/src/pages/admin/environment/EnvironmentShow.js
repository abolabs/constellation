import { DateField, LinearProgress, Show, TextField, useShowController } from "react-admin";
import { useLocation } from "react-router-dom";
import {
  Box,
  Typography
} from "@mui/material";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";

const EnvironmentShow = () => {
  const location = useLocation();
  const { error, isLoading } = useShowController();

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
      <Typography variant="h3">Environment</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout>
            <TextField source="id" />
            <TextField source="name" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

export default EnvironmentShow;
