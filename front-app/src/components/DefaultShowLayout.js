import { LinearProgress, SimpleShowLayout, useShowContext } from "react-admin";
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

const DefaultShowLayout = ({object, title, children}) => {
  const location = useLocation();
  const { error, isLoading, record } = useShowContext();

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
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader object={object} record={record} title={record?.name}/>
            <CardContent
              sx={{
                "& .RaLabeled-label": {
                  fontWeight: "bold",
                }
              }}
            >
                <SimpleShowLayout>
                  {children}
                </SimpleShowLayout>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Box>
  );
};

export default DefaultShowLayout;
