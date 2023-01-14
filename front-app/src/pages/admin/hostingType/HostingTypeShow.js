import { DateField, LinearProgress, Show, SimpleShowLayout, TextField, useShowController } from "react-admin";
import { useLocation } from "react-router-dom";
import {
  Box,
  Card,
  CardContent,
  Grid,
  Typography
} from "@mui/material";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import AlertError from "@components/alerts/AlertError";

const HostingTypeShow = () => {
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
      <Typography variant="h3">Hosting Type</Typography>
      <Box sx={{ flexGrow: 1, mt: "1rem" }}>
        <Grid container>
          <Grid item xs={12}>
            <Show actions={null}>
              <Card>
                <DefaultCardHeader object="hosting_types" record={record} title={record?.name}/>
                <CardContent
                  sx={{
                    "& .RaLabeled-label": {
                      fontWeight: "bold",
                    }
                  }}
                >
                    <SimpleShowLayout>
                      <TextField source="id" />
                      <TextField source="name" />
                      <TextField source="description" />
                      <DateField source="created_at" />
                      <DateField source="updated_at" />
                    </SimpleShowLayout>
                </CardContent>
              </Card>
            </Show>
          </Grid>
        </Grid>
      </Box>
    </>
  );
};

export default HostingTypeShow;
