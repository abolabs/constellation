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

import {
  Box,
  Button,
  Card,
  CardActions,
  CardContent,
  Divider,
  Grid,
  LinearProgress,
  Typography,
  useTheme,
} from "@mui/material";
import { useEffect, useState } from "react";
import { useDataProvider } from "react-admin";

import ViewModuleIcon from "@mui/icons-material/ViewModule";
import AppRegistrationIcon from "@mui/icons-material/AppRegistration";
import SettingsSystemDaydreamIcon from "@mui/icons-material/SettingsSystemDaydream";
import ChevronRightIcon from "@mui/icons-material/ChevronRight";
import { useNavigate } from "react-router-dom";

import AlertError from "@components/alerts/AlertError";
import AbstractMapping from "@pages/application-mapping/AbstractMapping";

const Dashboard = () => {
  const theme = useTheme();
  const navigate = useNavigate();
  const dataProvider = useDataProvider();
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState();
  const [stats, setStats] = useState({});

  useEffect(() => {
    dataProvider
      .get(`application-mapping/dashboard`)
      .then(({ data }) => {
        setStats(data);
        setLoading(false);
      })
      .catch((error) => {
        setError(error);
        setLoading(false);
      });
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [dataProvider]);

  if (loading) {
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
      <Typography variant="h3">Dashboard</Typography>
      <Divider sx={{ mb: 2, color: theme.palette.divider }} />
      <Grid
        container
        spacing={{ xs: 2, md: 3 }}
        columns={{ xs: 8, sm: 8, md: 8, lg: 12 }}
      >
        <Grid item xs={4}>
          <StatisticCard
            title="Applications"
            value={stats?.nbApp}
            color={theme.palette.primary.main}
            colorText={theme.palette.primary.contrastText}
            icon={
              <AppRegistrationIcon
                sx={{ ml: "auto", mb: "auto" }}
                fontSize="medium"
              />
            }
            onClick={() => navigate("/application-mapping/by-app")}
          />
          <AbstractMapping
            mappingUrl="application-mapping/graph-nodes-app-map"
            filterList={["environnement_id", "application_id", "team_id"]}
            height="32rem"
            asWidget={true}
            graphId="graph-nodes-app-map"
          />
        </Grid>
        <Grid item xs={4}>
          <StatisticCard
            title="Instances de services / Services"
            value={`${stats?.nbInstances} / ${stats?.nbServices}`}
            color={theme.palette.error.main}
            colorText={theme.palette.error.contrastText}
            icon={
              <ViewModuleIcon
                sx={{ ml: "auto", mb: "auto" }}
                fontSize="medium"
              />
            }
            onClick={() => navigate("/application-mapping/services-by-app")}
          />
          <AbstractMapping
            mappingUrl="application-mapping/graph-nodes-by-app"
            filterList={[]}
            height="32rem"
            asWidget={true}
            graphId="graph-nodes-by-app"
          />
        </Grid>
        <Grid item xs={4}>
          <StatisticCard
            title="Hébergements"
            value={stats?.nbHostings}
            color={theme.palette.info.main}
            colorText={theme.palette.info.contrastText}
            icon={
              <SettingsSystemDaydreamIcon
                sx={{ ml: "auto" }}
                fontSize="small"
              />
            }
            onClick={() => navigate("/application-mapping/by-hosting")}
          />
          <AbstractMapping
            mappingUrl="application-mapping/graph-nodes-by-hosting"
            filterList={[]}
            height="32rem"
            asWidget={true}
            graphId="graph-nodes-by-hosting"
          />
        </Grid>
      </Grid>
    </>
  );
};

const StatisticCard = ({ title, value, icon, color, colorText, ...rest }) => {
  const theme = useTheme();
  return (
    <Card
      sx={{
        backgroundColor: color,
        color: colorText,
        cursor: "pointer",
        borderRadius: theme.shape.borderRadius,
      }}
      {...rest}
    >
      <CardContent>
        <div style={{ display: "flex", alignItems: "center" }}>
          <div style={{ flexGrow: 1 }}>
            <Typography variant="h3">{value}</Typography>
            <Typography
              sx={{
                opacity: 0.6,
                textTransform: "uppercase",
                fontSize: "0.75rem",
              }}
            >
              {title}
            </Typography>
          </div>
          {icon}
        </div>
      </CardContent>
      <Divider color={colorText} />
      <CardActions>
        <Button
          sx={{
            color: colorText,
            fontSize: "0.62rem",
            opacity: 0.6,
          }}
        >
          Voir plus
        </Button>
        <ChevronRightIcon sx={{ ml: "auto" }} fontSize="small" />
      </CardActions>
    </Card>
  );
};

export default Dashboard;
