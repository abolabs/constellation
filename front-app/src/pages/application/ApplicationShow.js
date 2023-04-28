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

import { useState } from "react";
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
  List,
  ListItem,
  ListItemButton,
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
} from "react-admin";
import AddBoxIcon from "@mui/icons-material/AddBox";
import { grey } from "@mui/material/colors";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import CreateServiceInstanceModal from "@pages/serviceInstance/CreateServiceInstanceModal";
import ServiceInstanceCard from "@pages/serviceInstance/ServiceInstanceCard";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import Tag from "@components/styled/Tag";

const ApplicationShow = () => {
  const location = useLocation();
  const theme = useTheme();
  const { error, isLoading, record } = useShowController();
  const [currentEnvId, setCurrentEnvId] = useState(1);
  const [openModal, setOpenModal] = useState(false);

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
      <Typography
        variant="h3"
        sx={{
          mb: 2,
        }}
      >
        Application
      </Typography>

      <Show actions={<></>}>
        <ApplicationShowLayout />
      </Show>

      <Grid container mt={2}>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title="Instance de service"
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
                <Button onClick={() => { setOpenModal(true); }}>
                  <AddBoxIcon />
                </Button>
              }
            />
            <CardContent
              sx={{
                background: theme.palette.background.default,
              }}
            >
              <Grid container>
                <Grid item xs={4} md={3} lg={2}>
                  <EnvironmentSelector
                    record={record}
                    currentEnvId={currentEnvId}
                    setCurrentEnvId={setCurrentEnvId}
                  />
                </Grid>
                <Grid item xs={8} md={9} lg={10} p={2}
                  sx={{
                    borderLeft: 1,
                    borderColor: grey[300],
                  }}
                >
                  <Grid
                    container
                    direction="row"
                    justifyContent="flex-start"
                    alignItems="stretch"
                    spacing={{ xs: 2, md: 3 }}
                    columns={{ xs: 8, sm: 8, md: 8, lg: 12 }}
                  >
                  {record?.meta?.serviceInstances?.map((instance) => (
                    instance?.environnement_id === currentEnvId
                      ? (
                        <Fade key={instance?.id} in={true} timeout={500}>
                          <Grid item xs={8} sm={8} md={4} lg={3}>
                              <ServiceInstanceCard key={instance?.id} {...instance} {...currentEnvId}/>
                          </Grid>
                        </Fade>
                      ) :null
                  ))}
                  </Grid>
                </Grid>
              </Grid>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
      <CreateServiceInstanceModal
        applicationData={record}
        environnementId={currentEnvId}
        open={openModal}
        handleClose={() => setOpenModal(false)}
      />
    </>
  );
};

const EnvironmentSelector = ({record, currentEnvId, setCurrentEnvId}) => (
  <List>
    {record?.meta?.countByEnv && record?.meta?.countByEnv.map((env) => (
      <ListItem key={env?.id}>
        <ListItemButton onClick={() => setCurrentEnvId(env?.id)} selected={currentEnvId === env?.id}>
          <ListItemText>
            <Tag label={env?.service_instances_count} color="primary" size="small" />
          </ListItemText>
          <ListItemText primary={env?.name} />
        </ListItemButton>
      </ListItem>
    ))}
  </List>
);

const ApplicationShowLayout = () => {
  const { record } = useShowContext();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader object="applications" record={record} title={record?.name}/>
            <CardContent>
              <List
                sx={{
                  width: "100%",
                  display: "flex",
                  flexDirection: "row",

                  "& .MuiTypography-body1": {
                    fontWeight: "bold",
                  },
                }}
              >
                <ListItem>
                  <ListItemText
                    primary="id"
                    secondary={<NumberField source="id" />}
                  />
                </ListItem>
                <ListItem>
                  <ListItemText
                    primary="Team"
                    secondary={
                      <ReferenceField source="team_id" reference="teams" link="show">
                        <TextField source="name" />
                      </ReferenceField>
                    }
                  />
                </ListItem>
                <ListItem>
                  <ListItemText
                    primary="Creation date"
                    secondary={<DateField source="created_at" />}
                  />
                </ListItem>
                <ListItem>
                  <ListItemText
                    primary="Last update date"
                    secondary={<DateField source="updated_at" />}
                  />
                </ListItem>
              </List>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Box>
  );
};

export default ApplicationShow;
