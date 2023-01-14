import { DateField, LinearProgress, Show, TextField, useShowController } from "react-admin";
import { useLocation } from "react-router-dom";
import {
  Box,
  Typography
} from "@mui/material";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";

const TeamShow = () => {
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
      <Typography variant="h3">Team</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout
          object="teams"
          title="Team"
        >
            <TextField source="id" />
            <TextField source="name" />
            <TextField source="manager" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

export default TeamShow;
