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
import { useLocation, useNavigate } from "react-router-dom";
import {
  Badge,
  Box,
  Button,
  Card,
  CardHeader,
  CardContent,
  Grid,
  Fade,
  LinearProgress,
  Link,
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

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import CreateVersionModal from "@pages/serviceVersion/CreateVersionModal";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";

const ServiceShow = () => {
  const location = useLocation();
  const theme = useTheme();
  const { error, isLoading, record, refetch } = useShowController();
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
        Service
      </Typography>

      <Show actions={<></>}>
        <ServiceShowLayout />
      </Show>

      <Grid container mt={2}>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title="Version(s)"
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
                <Grid item xs={12} p={2}>
                  <Grid
                    container
                    direction="row"
                    justifyContent="flex-start"
                    alignItems="stretch"
                    spacing={{ xs: 2, md: 4, lg: 4 }}
                    columns={{ xs: 8, sm: 8, md: 8, lg: 12 }}
                  >
                  {record?.meta?.serviceByApplication?.map((versionObj) => (
                    <Fade key={versionObj?.id} in={true} timeout={500}>
                      <Grid item xs={8} sm={8} md={4} lg={3}>
                          <VersionCard key={versionObj?.id} {...versionObj}/>
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
      <CreateVersionModal
        serviceID={record?.id}
        open={openModal}
        handleClose={() => {
          setOpenModal(false);
          refetch();
        }}
      />
    </>
  );
}

const VersionCard = (versionObj) => {
  const navigate = useNavigate();
  const theme = useTheme();

  return (
    <Card sx={{
      height: '100%',
    }}>
      <CardHeader
        title={`v. ${versionObj?.version}`}
        sx={{
          background: theme?.palette?.secondary?.main,
          color: theme?.palette?.secondary?.contrastText,
        }}
      />
      <CardContent sx={{
        height: "60%",
        "& .MuiTypography-body1": {
          fontWeight: "bold",
        }
      }}>
        <List
          sx={{
            "& .MuiListItem-root": {
              padding: 0,
            },
          }}
        >
          <ListItem>
            <ListItemText
              primary="Creation date"
              secondary={<DateField source="created_at" record={versionObj}/>}
            />
          </ListItem>
          <ListItem>
            <ListItemText
              primary="Updated date"
              secondary={<DateField source="updated_at" record={versionObj}/>}
            />
          </ListItem>
          <ListItem>
            <ListItemText
              primary="Nb instances par application"
              secondaryTypographyProps={{
                component: 'div'
              }}
              secondary={
                <List>
                  {Object.keys(versionObj?.apps).map((index) => (
                    <ListItem key={index}>
                      <ListItemButton
                        onClick={() => navigate(`/applications/${versionObj?.apps[index]?.id}/show`)}
                      >
                          <ListItemText
                            primary={
                              <Badge
                                badgeContent={versionObj?.apps[index]?.total}
                                color="secondary"
                                anchorOrigin={{
                                  vertical: 'top',
                                  horizontal: 'right',
                                }}
                                sx={{
                                  width: '100%',
                                  '& .MuiBadge-badge': {
                                    top: '0.5rem',
                                    right: '0.5rem',
                                    border: `2px solid ${theme.palette.background.paper}`,
                                    padding: '0 1rem',
                                  },
                                }}
                              >
                                {versionObj?.apps[index]?.name}
                              </Badge>
                            }
                          />
                      </ListItemButton>
                    </ListItem>
                  ))}
                </List>
              }
            />
          </ListItem>
        </List>
      </CardContent>
    </Card>
  );
};

const ServiceShowLayout = () => {
  const { record } = useShowContext();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader object="services" record={record} title={record?.name} canDelete={!record?.meta?.serviceByApplication?.length}/>
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
                      <ReferenceField source="team_id" reference="teams">
                        <TextField source="name" />
                      </ReferenceField>
                    }
                  />
                </ListItem>
                <ListItem>
                  <ListItemText
                    primary="Git Repo"
                    secondary={
                      <Link href={record?.git_repo}>
                        {record?.git_repo}
                      </Link>
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

export default ServiceShow;
