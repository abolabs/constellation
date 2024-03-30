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

import { useRef, useState } from "react";
import { useLocation } from "react-router-dom";
import {
  Box,
  Button,
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
  Tabs,
  Tab,
  tabsClasses,
} from "@mui/material";
import {
  DateField,
  NumberField,
  ReferenceField,
  Show,
  TextField,
  usePermissions,
  useShowContext,
  useShowController,
  useTranslate,
} from "react-admin";
import AddBoxIcon from "@mui/icons-material/AddBox";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import CreateServiceInstanceModal from "@pages/service-instance/CreateServiceInstanceModal";
import ServiceInstanceCard from "@pages/service-instance/ServiceInstanceCard";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import Tag from "@components/styled/Tag";
import WithPermission from "@components/WithPermission";

const ApplicationShow = () => {
  const location = useLocation();
  const theme = useTheme();
  const { error, isLoading, record } = useShowController();
  const [currentEnvId, setCurrentEnvId] = useState(1);
  const [openModal, setOpenModal] = useState(false);
  const { permissions } = usePermissions();
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
        {t("resources.applications.name")}
      </Typography>

      <Show actions={<></>}>
        <ApplicationShowLayout />
      </Show>
      {permissions.includes("view service_instances") ? (
        <Grid container mt={2}>
          <Grid item xs={12}>
            <Card>
              <CardHeader
                title={t("resources.service_instances.name")}
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
                action={
                  permissions.includes("create service_instances") ? (
                    <Button
                      onClick={() => {
                        setOpenModal(true);
                      }}
                    >
                      <AddBoxIcon />
                    </Button>
                  ) : null
                }
              />
              <EnvironmentSelector
                record={record}
                currentEnvId={currentEnvId}
                setCurrentEnvId={setCurrentEnvId}
              />
              <CardContent
                sx={{
                  background: theme.palette.background.default,
                }}
              >
                <Grid
                  container
                  direction="row"
                  justifyContent="flex-start"
                  alignItems="stretch"
                  spacing={{ xs: 2, md: 3 }}
                  columns={{ xs: 8, sm: 8, md: 10, lg: 12 }}
                >
                  {record?.meta?.serviceInstances?.map((instance) =>
                    instance?.environment_id === currentEnvId ? (
                      <Fade key={instance?.id} in={true} timeout={500}>
                        <Grid item xs={8} sm={8} md={4} lg={3}>
                          <ServiceInstanceCard
                            key={instance?.id}
                            {...instance}
                            {...currentEnvId}
                          />
                        </Grid>
                      </Fade>
                    ) : null
                  )}
                </Grid>
              </CardContent>
            </Card>
          </Grid>
        </Grid>
      ) : null}
      <CreateServiceInstanceModal
        applicationData={record}
        environmentId={currentEnvId}
        open={openModal}
        handleClose={() => setOpenModal(false)}
      />
    </>
  );
};

const EnvironmentSelector = ({ record, currentEnvId, setCurrentEnvId }) => {
  const [windowWidth] = useState(useRef(window.innerWidth)?.current)
  const handleChange = (_event, newValue) => {
    setCurrentEnvId(newValue);
  };

  return (
    <Box
      sx={{
        flexGrow: 1,
        bgcolor: 'background.paper',
        width: { xs: windowWidth - 10, sm: '100%' }
      }}
    >
      <Tabs
        value={currentEnvId}
        onChange={handleChange}
        variant="scrollable"
        scrollButtons="auto"
        allowScrollButtonsMobile={true}
        textColor="secondary"
        indicatorColor="secondary"
        sx={{
          [`& .${tabsClasses.scrollButtons}`]: {
            '&.Mui-disabled': { opacity: 0.3 },
          },
        }}
      >
        {record?.meta?.countByEnv &&
          record?.meta?.countByEnv.map((env) => (
            <Tab
              iconPosition="start"
              icon={<Tag
                label={env?.service_instances_count}
                color="primary"
                size="small"
              />}
              label={env?.name}
              value={env?.id}
              key={env?.id}
            />
          ))
        }
      </Tabs>
    </Box>
  );
}

const ApplicationShowLayout = () => {
  const { record } = useShowContext();
  const { permissions } = usePermissions();
  const t = useTranslate();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader
              object="applications"
              record={record}
              title={record?.name}
            />
            <CardContent>
              <Grid
                container
                direction="row"
                justifyContent="flex-start"
                alignItems="stretch"
                spacing={{ xs: 0, md: 1 }}
                columns={{ xs: 12, sm: 12, md: 8, lg: 12 }}
              >
                <Grid item xs={6} sm={6} md={4} lg={3}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.applications.fields.id")}
                      secondary={<NumberField source="id" />}
                    />
                  </ListItem>
                </Grid>
                {permissions.includes("view teams") ? (
                  <Grid item xs={6} sm={6} md={4} lg={3}>
                    <ListItem>
                      <ListItemText
                        primary={t("resources.applications.fields.team_id")}
                        secondary={
                          <ReferenceField
                            source="team_id"
                            reference="teams"
                            link="show"
                          >
                            <TextField source="name" />
                          </ReferenceField>
                        }
                      />
                    </ListItem>
                  </Grid>
                ) : null}
                <Grid item xs={6} sm={6} md={4} lg={3}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.applications.fields.created_at")}
                      secondary={<DateField source="created_at" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={3}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.applications.fields.updated_at")}
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

const ApplicationShowWithPermission = () => (
  <WithPermission permission="view applications" element={ApplicationShow} />
);

export default ApplicationShowWithPermission;
