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

import { useCallback, useEffect, useState } from "react";
import {
  Box,
  Card,
  CardActions,
  CardContent,
  LinearProgress,
  Tooltip,
  Typography,
  useTheme
} from "@mui/material";
import { useLocation } from "react-router-dom";
import {
  ReferenceArrayInput,
  ReferenceInput,
  SelectArrayInput,
  SelectInput,
  SimpleForm,
  useDataProvider
} from "react-admin";
import CytoscapeComponent from 'react-cytoscapejs';

import AppBreadCrumd from "@/layouts/AppBreadCrumd";
import Tag from "@components/styled/Tag";
import AlertError from "@components/alerts/AlertError";
import { serviceInstanceDepLevel } from "@pages/serviceInstance/serviceInstanceDepLevel";
import { useFormContext, useWatch } from "react-hook-form";
import Graph from "@utils/Graph";

const MappingByApp = () => {
  const location = useLocation();
  const theme = useTheme();
  const [filter, setFilter] = useState({});
  const [elements, setElements] = useState();
  const dataProvider = useDataProvider();
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState();

  useEffect(() => {
    dataProvider
      .get(`application-mapping/by-app`)
      .then(({ data }) => {
          setFilter({
            ...filter,
            environnement_id: data?.environnement_id
          })
          setLoading(false);
      })
      .catch(error => {
          setError(error);
          setLoading(false);
      })
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
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Dependencies per application</Typography>
      <Box
        sx={{
          background: theme.palette.background.default,
          backgroundSize: '40px 40px',
          backgroundImage: `radial-gradient(circle, ${theme.palette.grey[500]} 1px, rgba(0, 0, 0, 0) 1px)`,
          height: '90%',
          borderRadius: theme.shape.borderRadius,
          position: 'relative',
          border: 6,
          borderColor: theme.palette.secondary.light,
          padding: 0,
          mb: 0.5,
          mt: 0.5,
         }}
      >
        <Card
          sx={{
            maxWidth: 316,
            borderRadius: theme?.shape?.borderRadius,
            mt: 0,
            p: 1,
            pt: 0,
            position: 'absolute',
            top: 0,
            left: 0,
            zIndex: 1,
            opacity: 0.96,
          }}
        >
          <CardContent
            sx={{
              p: 0,
              m: 0,
              '.MuiFormControl-root': {
                minWidth: '280px'
              },
            }}
          >
             <SimpleForm
              toolbar={null}
              sx={{ p: '0.5rem 0', width: '75%' }}
            >
              <MappingFilters
                defaultFilter={filter}
                setElements={setElements}
                dataProvider={dataProvider}
                setError={setError}
              />
            </SimpleForm>
          </CardContent>
          <CardActions
            sx={{
              fontStyle: 'italic',
             }}
          >
            <Typography variant="caption">
              Utiliser le menu contextuel pour accéder au détail de chaque noeud.
              <br />
              (Clic gauche 2s ou clic droit)
            </Typography>
          </CardActions>
        </Card>
        <CytoscapeComponent
          id="graph_per_app"
          cy={(cy) => {
            const graph = new Graph(cy);
            graph.load({
              selector: "graph_per_app",
              elements: elements,
              theme: theme,
            });
          }}
          layout={Graph.baseLayoutConfig}
          style={ { width: '100%', height: '100%' } }
        />
      </Box>
    </>
  );
}

const MappingFilters = ({defaultFilter, setElements, dataProvider, setError}) => {
  useFormContext();
  const watchFields = useWatch([
      'environnement_id',
      'application_id',
      'team_id',
      'hosting_id'
  ]);

  console.log("defaultFilter", defaultFilter);

  const refreshGraph = useCallback((filterParams) => {
    dataProvider
      .get(
        `application-mapping/graph-nodes-app-map`,
        filterParams
      )
      .then(({ data }) => {
        setElements(data);
      })
      .catch(error => {
        setError(error);
      })
  }, [dataProvider, setElements, setError]);

  useEffect(() => {
    if (watchFields?.length === 0) {
      return;
    }
    refreshGraph(watchFields);
  }, [watchFields, refreshGraph]);

  useEffect(() => {
    if (!defaultFilter?.environnement_id) {
      return;
    }
    refreshGraph({
      environnement_id: defaultFilter?.environnement_id,
      application_id: [],
      team_id: []
    });
  }, [defaultFilter, refreshGraph]);

  return (
    <>
      <Typography variant="h5">Filter</Typography>
      <ReferenceInput source="environnement_id" reference="environnements">
        <SelectInput
          isRequired={true}
          optionText="name"
          defaultValue={defaultFilter?.environnement_id}
        />
      </ReferenceInput>
      <ReferenceArrayInput source="application_id" reference="applications">
        <SelectArrayInput optionText="name" />
      </ReferenceArrayInput>
      <ReferenceArrayInput source="team_id" reference="teams">
        <SelectArrayInput optionText="name" />
      </ReferenceArrayInput>
      <Typography variant="h5">Legend</Typography>
      <Typography variant="h6">Dependency level</Typography>
      {
        Object.values(serviceInstanceDepLevel).map((level, index) =>
          <Tooltip title={level?.description}>
            <Tag
              key={index}
              label={`Level: ${level.label}`}
              color={level?.color}
              size="small"
              component="span"
              sx={{
                p: 0,
                height: '100%',
                cursor: "inherit",
                width: '8rem',
              }}
            />
          </Tooltip>
        )
      }
    </>
  );
}

export default MappingByApp;
