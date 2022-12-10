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
  List,
  ListItem,
  ListItemButton,
  ListItemText,
  Typography,
  useTheme,
} from "@mui/material";
import {
  DateField,
  DeleteWithConfirmButton,
  NumberField,
  ReferenceField,
  Show,
  TextField,
  useShowContext,
  useShowController,
} from "react-admin";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import EditIcon from "@mui/icons-material/Edit";
import AddBoxIcon from "@mui/icons-material/AddBox";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import CreateVersionModal from "@pages/serviceVersion/CreateVersionModal";

const ServiceShow = () => {
  const location = useLocation();
  const theme = useTheme();
  const { error, isLoading, record } = useShowController();
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
        handleClose={() => setOpenModal(false)}
      />
    </>
  );
}

const VersionCard = (versionObj) => {
  const navigate = useNavigate();
  const theme = useTheme();

  return (
    <Card sx={{
      height: '26vh',
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
  const navigate = useNavigate();
  const theme = useTheme();

  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <CardHeader
              title={record.name}
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
                <>
                  <DeleteWithConfirmButton />
                  <Button
                    onClick={() => navigate(`/services/${record.id}/edit`)}
                  >
                    <EditIcon />
                    &nbsp;&nbsp;Edit
                  </Button>
                  <Button onClick={() => navigate(-1)}>
                    <ChevronLeftIcon />
                    &nbsp;&nbsp;Go back
                  </Button>
                </>
              }
            />
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
                    secondary={<NumberField source="git_repo" />}
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
