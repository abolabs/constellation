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

import { useLocation } from "react-router-dom";
import {
  Box,
  Card,
  CardHeader,
  CardContent,
  Grid,
  Fade,
  LinearProgress,
  ListItem,
  ListItemText,
  Typography,
  useTheme,
} from "@mui/material";
import {
  DateField,
  NumberField,
  ReferenceField,
  Show,
  TextField,
  useShowContext,
  useShowController,
  useTranslate,
} from "react-admin";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import ServiceInstanceCard from "@pages/service-instance/ServiceInstanceCard";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import WithPermission from "@components/WithPermission";

const HostingShow = () => {
  const location = useLocation();
  const theme = useTheme();
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
      <Typography
        variant="h3"
        sx={{
          mb: 2,
        }}
      >
        {t("resources.hostings.name")}
      </Typography>

      <Show actions={<></>}>
        <HostingShowLayout />
      </Show>

      <Grid container mt={2}>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title={t("Instances")}
              titleTypographyProps={{
                variant: "h5",
              }}
              sx={{
                background: theme?.palette?.primary?.main,
                color: theme?.palette?.primary?.contrastText,
                "& .MuiButton-root": {
                  color: theme?.palette?.primary?.contrastText,
                },
              }}
            />
            <CardContent
              sx={{
                background: theme.palette.background.default,
              }}
            >
              <Grid container>
                <Grid item xs={12} p={0}>
                  <Grid
                    container
                    direction="row"
                    justifyContent="flex-start"
                    alignItems="stretch"
                    spacing={{ xs: 2 }}
                    columns={{ xs: 8, sm: 8, md: 8, lg: 12 }}
                  >
                    {record?.meta?.serviceInstances?.map((instance) => (
                      <Fade key={instance?.id} in={true} timeout={500}>
                        <Grid item xs={8} sm={8} md={4} lg={4}>
                          <ServiceInstanceCard
                            key={instance?.id}
                            {...instance}
                          />
                        </Grid>
                      </Fade>
                    ))}
                  </Grid>
                </Grid>
              </Grid>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </>
  );
};

const HostingShowLayout = () => {
  const { record } = useShowContext();
  const t = useTranslate();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader
              object="hostings"
              record={record}
              title={record?.name}
              canDelete={!record?.meta?.serviceInstances?.length}
            />
            <CardContent>
              <Grid
                container
                direction="row"
                justifyContent="flex-start"
                alignItems="stretch"
                spacing={{ xs: 1 }}
                columns={{ xs: 6, sm: 6, md: 8, lg: 12 }}
              >
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.hostings.fields.id")}
                      secondary={<NumberField source="id" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.hostings.fields.name")}
                      secondary={<TextField source="name" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.hostings.fields.hosting_type_id")}
                      secondary={
                        <ReferenceField
                          source="hosting_type_id"
                          reference="hosting_types"
                          link="show"
                        >
                          <TextField source="name" />
                        </ReferenceField>
                      }
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.hostings.fields.localisation")}
                      secondary={<TextField source="localisation" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.hostings.fields.created_at")}
                      secondary={<DateField source="created_at" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.hostings.fields.updated_at")}
                      secondary={<DateField source="updated_at" />}
                    />
                  </ListItem>
                </Grid>
              </Grid>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Box>
  );
};

const HostingShowWithPermission = () => (
  <WithPermission permission="view hostings" element={HostingShow} />
);

export default HostingShowWithPermission;
