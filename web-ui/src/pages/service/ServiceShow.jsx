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
  usePermissions,
  useShowContext,
  useShowController,
  useTranslate,
} from "react-admin";
import AddBoxIcon from "@mui/icons-material/AddBox";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import CreateVersionModal from "@pages/service-version/CreateVersionModal";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import WithPermission from "@components/WithPermission";

const ServiceShow = () => {
  const location = useLocation();
  const theme = useTheme();
  const { error, isLoading, record, refetch } = useShowController();
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
        {t("resources.services.name")}
      </Typography>
      <Show actions={<></>}>
        <ServiceShowLayout />
      </Show>
      <Grid container mt={2}>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title={t("resources.service_versions.fields.version")}
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
                permissions.includes("create service_versions") ? (
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
                    spacing={{ xs: 1, md: 2, lg: 2 }}
                    columns={{ xs: 8, sm: 8, md: 8, lg: 12 }}
                  >
                    {record?.meta?.serviceByApplication?.map((versionObj) => (
                      <Fade key={versionObj?.id} in={true} timeout={500}>
                        <Grid item xs={8} sm={8} md={4} lg={3}>
                          <VersionCard key={versionObj?.id} {...versionObj} />
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
};

const VersionCard = (versionObj) => {
  const navigate = useNavigate();
  const theme = useTheme();
  const t = useTranslate();

  return (
    <Card
      sx={{
        height: "100%",
      }}
    >
      <CardHeader
        title={`v. ${versionObj?.version}`}
        sx={{
          background: theme?.palette?.secondary?.main,
          color: theme?.palette?.secondary?.contrastText,
        }}
      />
      <CardContent
        sx={{
          height: "60%",
          "& .MuiTypography-body1": {
            fontWeight: "bold",
          },
        }}
      >
        <List
          sx={{
            "& .MuiListItem-root": {
              padding: 0,
              mb: "auto",
            },
          }}
        >
          <ListItem>
            <ListItemText
              primary={t("resources.services.fields.created_at")}
              secondary={<DateField source="created_at" record={versionObj} />}
            />
          </ListItem>
          <ListItem>
            <ListItemText
              primary={t("resources.services.fields.updated_at")}
              secondary={<DateField source="updated_at" record={versionObj} />}
            />
          </ListItem>
          <ListItem>
            <ListItemText
              primary={t("Instances per application")}
              secondaryTypographyProps={{
                component: "div",
              }}
              secondary={
                <List>
                  {Object.keys(versionObj?.apps).map((index) => (
                    <ListItem key={index}>
                      <ListItemButton
                        onClick={() =>
                          navigate(
                            `/applications/${versionObj?.apps[index]?.id}/show`
                          )
                        }
                      >
                        <ListItemText
                          primary={
                            <Badge
                              badgeContent={versionObj?.apps[index]?.total}
                              color="secondary"
                              anchorOrigin={{
                                vertical: "top",
                                horizontal: "right",
                              }}
                              sx={{
                                width: "100%",
                                "& .MuiBadge-badge": {
                                  top: "100%",
                                  right: "0.25rem",
                                  border: `2px solid ${theme.palette.background.paper}`,
                                  padding: "0.75rem",
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
  const t = useTranslate();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader
              object="services"
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
                columns={{ xs: 12, sm: 12, md: 8, lg: 10 }}
              >
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary="id"
                      secondary={<NumberField source="id" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.services.fields.team_id")}
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
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.services.fields.created_at")}
                      secondary={<DateField source="created_at" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={6} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.services.fields.updated_at")}
                      secondary={<DateField source="updated_at" />}
                    />
                  </ListItem>
                </Grid>
                <Grid item xs={12} sm={6} md={4} lg={2}>
                  <ListItem>
                    <ListItemText
                      primary={t("resources.services.fields.git_repo")}
                      secondary={
                        <Link href={record?.git_repo}>{record?.git_repo}</Link>
                      }
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

const ServiceShowWithPermission = () => (
  <WithPermission permission="view services" element={ServiceShow} />
);

export default ServiceShowWithPermission;
