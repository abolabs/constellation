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

import { useCallback, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import {
  Box,
  Button,
  Card,
  CardHeader,
  CardContent,
  Grid,
  Fade,
  IconButton,
  LinearProgress,
  List,
  ListItem,
  ListItemText,
  Typography,
  useTheme,
} from "@mui/material";
import {
  BooleanField,
  Confirm,
  DateField,
  Link,
  NumberField,
  Show,
  TextField,
  UrlField,
  useDelete,
  usePermissions,
  useRefresh,
  useShowContext,
  useShowController,
  useTranslate,
} from "react-admin";
import AddBoxIcon from "@mui/icons-material/AddBox";
import EditIcon from "@mui/icons-material/Edit";
import KeyboardArrowRightIcon from "@mui/icons-material/KeyboardArrowRight";
import RemoveCircleOutlineIcon from "@mui/icons-material/RemoveCircleOutline";
import { blueGrey } from "@mui/material/colors";

import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGitAlt } from "@fortawesome/free-brands-svg-icons";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import Tag from "@components/styled/Tag";
import ItemCardHeader from "@components/styled/ItemCardHeader";
import {
  CreateServiceInstanceDepModal,
  CreateServiceInstanceRequieredByModal,
} from "@pages/admin/service-instance-dep/CreateServiceInstanceDepModal";
import { EditServiceInstanceDepModal } from "@pages/admin/service-instance-dep/EditServiceInstanceDepModal";
import { serviceInstanceDepLevel } from "./serviceInstanceDepLevel";
import WithPermission from "@components/WithPermission";

const ServiceInstanceShow = () => {
  const location = useLocation();
  const theme = useTheme();
  const { error, isLoading, record } = useShowController();
  const [openModalDependsOf, setOpenModalDependsOf] = useState(false);
  const [openModalRequieredBy, setOpenModalRequiredBy] = useState(false);
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
      <AppBreadCrumd location={location} />
      <Typography
        variant="h3"
        sx={{
          mb: 2,
        }}
      >
        <Link to={`/applications/${record?.application_id}/show`}>
          {record?.application_name}
        </Link>{" "}
        / {record?.service_name}
      </Typography>

      <Show actions={<></>}>
        <ServiceInstanceShowLayout />
      </Show>

      <Grid container mt={2}>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title={t("Dependencies")}
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
                permissions.includes("create service_instance_dependencies") ? (
                  <Button
                    onClick={() => {
                      setOpenModalDependsOf(true);
                    }}
                  >
                    <AddBoxIcon />
                  </Button>
                ) : null
              }
            />
            <CardContent
              sx={{
                background: theme.palette.background.paper,
              }}
            >
              <Grid
                container
                direction="row"
                justifyContent="flex-start"
                alignItems="stretch"
                spacing={{ xs: 2, md: 2, lg: 1 }}
                columns={{ xs: 8, sm: 8, md: 8, lg: 12 }}
              >
                {record?.meta?.instanceDependencies?.map((dep) => (
                  <Fade key={dep?.id} in={true} timeout={500}>
                    <Grid
                      item
                      xs={8}
                      sm={8}
                      md={4}
                      lg={3}
                      sx={{ minWidth: "16rem" }}
                    >
                      <DependencyCard key={dep?.id} type="depend_of" {...dep} />
                    </Grid>
                  </Fade>
                ))}
              </Grid>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
      <Grid container mt={2}>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title={t("Required by")}
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
                permissions.includes("create service_instance_dependencies") ? (
                  <Button
                    onClick={() => {
                      setOpenModalRequiredBy(true);
                    }}
                  >
                    <AddBoxIcon />
                  </Button>
                ) : null
              }
            />
            <CardContent
              sx={{
                background: theme.palette.background.paper,
              }}
            >
              <Grid
                container
                direction="row"
                justifyContent="flex-start"
                alignItems="stretch"
                spacing={{ xs: 2, md: 2, lg: 1 }}
                columns={{ xs: 8, sm: 8, md: 12, lg: 12 }}
              >
                {record?.meta?.instanceDependenciesSource?.map((dep) => (
                  <Fade key={dep?.id} in={true} timeout={500}>
                    <Grid
                      item
                      xs={8}
                      sm={8}
                      md={6}
                      lg={3}
                      sx={{ minWidth: "16rem" }}
                    >
                      <DependencyCard
                        key={dep?.id}
                        type="required_by"
                        {...dep}
                      />
                    </Grid>
                  </Fade>
                ))}
              </Grid>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
      <CreateServiceInstanceDepModal
        sourceServiceInstance={record}
        open={openModalDependsOf}
        handleClose={() => setOpenModalDependsOf(false)}
      />
      <CreateServiceInstanceRequieredByModal
        sourceServiceInstance={record}
        open={openModalRequieredBy}
        handleClose={() => setOpenModalRequiredBy(false)}
      />
    </>
  );
};

const DeleteDependency = ({ dep }) => {
  const depInfo =
    dep?.type === "depend_of"
      ? dep?.service_instance_dep
      : dep?.service_instance;
  const refresh = useRefresh();
  const [open, setOpen] = useState(false);
  const t = useTranslate();
  const [deleteOne, { isLoading }] = useDelete(
    "service_instance_dependencies",
    { id: dep?.id },
    {
      onSuccess: () => {
        setOpen(false);
        refresh();
      },
    }
  );

  const handleClick = () => setOpen(true);
  const handleDialogClose = () => setOpen(false);
  const handleConfirm = () => {
    deleteOne();
  };

  return (
    <>
      <IconButton
        aria-label={t("ra.action.delete")}
        disabled={isLoading}
        onClick={handleClick}
      >
        <RemoveCircleOutlineIcon />
      </IconButton>
      <Confirm
        isOpen={open}
        loading={isLoading}
        title={t("Remove dependency")}
        content={t(
          "Are you sure you to remove #%{dep_id} - %{service_name} instance has dependency ?",
          {
            dep_id: dep?.id,
            service_name: depInfo?.service_version?.service?.name,
          }
        )}
        onConfirm={handleConfirm}
        onClose={handleDialogClose}
      />
    </>
  );
};

const DependencyCard = (dep) => {
  const navigate = useNavigate();
  const theme = useTheme();
  const { record } = useShowController();
  const t = useTranslate();
  const depInfo =
    dep?.type === "depend_of"
      ? dep?.service_instance_dep
      : dep?.service_instance;
  const [openModalEditDependency, setOpenModalEditDependency] = useState(false);
  const { permissions } = usePermissions();

  const onClick = useCallback(() => {
    navigate(`/service_instances/${depInfo?.id}/show`);
  }, [depInfo?.id, navigate]);

  return (
    <Card
      sx={{
        border: 1,
        borderColor: blueGrey[700],
        height: "100%",
        minHeight: "20rem",
      }}
    >
      <ItemCardHeader
        title={depInfo?.service_version?.service?.name}
        subheader={depInfo?.application?.name}
        subheaderTypographyProps={{
          noWrap: true,
          sx: {
            overflow: "hidden",
            textOverflow: "ellipsis",
            maxWidth: "12vw",
            color: theme?.palette?.secondary?.contrastText,
            fontSize: "0.8rem !important",
          },
        }}
        sx={{
          background: theme?.palette?.secondary?.dark,
          color: theme?.palette?.secondary?.contrastText,
          pr: "2rem",
        }}
        action={
          <>
            {permissions.includes("delete service_instance_dependencies") ? (
              <DeleteDependency dep={dep} />
            ) : null}
            {permissions.includes("edit service_instance_dependencies") ? (
              <IconButton
                aria-label={t("ra.action.edit")}
                edge="end"
                onClick={() => {
                  setOpenModalEditDependency(true);
                }}
              >
                <EditIcon color="secondary" />
              </IconButton>
            ) : null}
          </>
        }
      />
      <CardContent
        sx={{
          p: "0.5rem 1rem",
        }}
      >
        <List
          sx={{
            height: "100%",
            "& .MuiListItem-root": {
              padding: 0,
            },
          }}
        >
          <ListItem
            secondaryAction={
              <IconButton
                aria-label={t("ra.action.show")}
                onClick={onClick}
                color="primary"
              >
                <KeyboardArrowRightIcon />
              </IconButton>
            }
          >
            <ListItemText primary={t("resources.service_instances.name")} />
          </ListItem>
          <ListItem sx={{ flexWrap: "wrap" }}>
            <Tag
              label={`${t("resources.service_instances.fields.id")}: ${depInfo?.id
                }`}
              color="primary"
              size="small"
            />
            &nbsp;
            <Tag
              label={`${t("resources.service_instances.fields.statut")}: ${depInfo?.statut ? "Active" : "Inactive"
                }`}
              color={depInfo?.statut ? "success" : "warning"}
              size="small"
            />
            &nbsp;
            <Tag
              label={`${t("resources.service_versions.fields.version")}: ${depInfo?.service_version?.version
                }`}
              color={"primary"}
              size="small"
            />
            &nbsp;
            <Tag
              label={`${t("resources.hostings.fields.name")}: ${depInfo?.hosting?.name
                }`}
              color={"info"}
              size="small"
            />
            &nbsp;
            {depInfo?.role ? (
              <Tag
                label={`${t("resources.service_instances.fields.role")}: ${depInfo?.role
                  }`}
                color="secondary"
                size="small"
              />
            ) : null}
            <br />
            <Tag
              label={
                <Link to={depInfo?.url} target="_blank" rel="noopener">
                  <FontAwesomeIcon icon={faGitAlt} />
                  &nbsp;{t("resources.services.fields.git_repo")}
                </Link>
              }
              size="small"
            />
          </ListItem>
          <ListItem>
            <ListItemText
              primary={t("Dependency")}
              primaryTypographyProps={{
                sx: {
                  fontWeight: "bold",
                  mt: "0.5rem",
                  mb: "0.5rem",
                },
              }}
              secondary={
                <>
                  <Tag
                    label={`Level: ${serviceInstanceDepLevel[dep?.level].label
                      }`}
                    color={
                      serviceInstanceDepLevel[dep?.level]
                        ? serviceInstanceDepLevel[dep?.level]?.color
                        : null
                    }
                    size="small"
                    component="span"
                    sx={{
                      mb: "0.5rem",
                    }}
                  />
                  <br />
                  {dep?.description}
                </>
              }
            />
          </ListItem>
        </List>
      </CardContent>
      <EditServiceInstanceDepModal
        currentServiceInstanceDep={dep}
        depType={dep?.type}
        sourceServiceInstance={record}
        open={openModalEditDependency}
        handleClose={() => setOpenModalEditDependency(false)}
      />
    </Card>
  );
};

const ServiceInstanceShowLayout = () => {
  const { record } = useShowContext();
  const t = useTranslate();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader
              object="service_instances"
              record={record}
              title={record?.environment_name}
            />
            <CardContent>
              <Grid
                container
                direction="row"
                justifyContent="flex-start"
                alignItems="stretch"
                sx={{
                  p: 1,
                  "& .MuiTypography-body1": {
                    fontWeight: "bold",
                  },
                }}
              >
                <Grid item xs={3}>
                  <ListItemText
                    primary="id"
                    secondary={<NumberField source="id" />}
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t("resources.services.fields.name")}
                    secondary={
                      <Link to={`/services/${record?.service_id}/show`}>
                        <TextField
                          source="service_name"
                          sx={{
                            mr: 1,
                          }}
                        />
                        <Tag
                          label={`version: ${record?.service_version}`}
                          component="span"
                          color="primary"
                          size="small"
                          variant="outlined"
                        />
                      </Link>
                    }
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t(
                      "resources.service_instances.fields.environment_name"
                    )}
                    secondary={
                      <Link to={`/environments/${record?.environment_id}/show`}>
                        <TextField
                          source="environment_name"
                          sx={{
                            mr: 1,
                          }}
                        />
                      </Link>
                    }
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t(
                      "resources.service_instances.fields.hosting_name"
                    )}
                    secondary={
                      <Link to={`/hostings/${record?.hosting_id}/show`}>
                        <TextField
                          source="hosting_name"
                          sx={{
                            mr: 1,
                          }}
                        />
                      </Link>
                    }
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t("resources.service_instances.fields.url")}
                    secondary={<UrlField source="url" />}
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t("resources.service_instances.fields.role")}
                    secondary={<TextField source="role" />}
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t("resources.service_instances.fields.statut")}
                    secondary={<BooleanField source="statut" />}
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t("resources.service_instances.fields.created_at")}
                    secondary={<DateField source="created_at" />}
                  />
                </Grid>
                <Grid item xs={3}>
                  <ListItemText
                    primary={t("resources.service_instances.fields.updated_at")}
                    secondary={<DateField source="updated_at" />}
                  />
                </Grid>
              </Grid>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Box>
  );
};

const ServiceInstanceShowWithPermission = () => (
  <WithPermission
    permission="view service_instances"
    element={ServiceInstanceShow}
  />
);

export default ServiceInstanceShowWithPermission;
