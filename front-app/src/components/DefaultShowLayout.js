import { LinearProgress, SimpleShowLayout, useShowContext } from "react-admin";
import {
  Box,
  Card,
  CardContent,
  Grid,
} from "@mui/material";

import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import AlertError from "@components/alerts/AlertError";

const DefaultShowLayout = ({title=null, canDelete=true, canEdit=true, children}) => {
  const { error, isLoading, record, resource } = useShowContext();

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
            <DefaultCardHeader
              object={resource}
              record={record}
              title={title || record?.name}
              canDelete={canDelete}
              canEdit={canEdit}
            />
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
