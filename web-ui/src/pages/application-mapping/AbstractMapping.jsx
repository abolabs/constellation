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

import { memo, useCallback, useEffect, useRef, useState } from "react";
import {
  Box,
  Button,
  Card,
  CardActions,
  CardContent,
  Collapse,
  Grid,
  IconButton,
  LinearProgress,
  Stack,
  TextField,
  Tooltip,
  Typography,
  useMediaQuery,
  useTheme,
} from "@mui/material";
import FilterListIcon from '@mui/icons-material/FilterList';
import FilterListOffIcon from '@mui/icons-material/FilterListOff';
import CloseIcon from "@mui/icons-material/Close";
import { useLocation } from "react-router-dom";
import {
  ReferenceArrayInput,
  ReferenceInput,
  SelectArrayInput,
  SelectInput,
  SimpleForm,
  useDataProvider,
  useShowController,
  useTranslate,
} from "react-admin";
import CytoscapeComponent from "react-cytoscapejs";

import AppBreadCrumb from "@/layouts/AppBreadCrumb";
import Tag from "@components/styled/Tag";
import AlertError from "@components/alerts/AlertError";
import { serviceInstanceDepLevel } from "@pages/service-instance/serviceInstanceDepLevel";
import { useFormContext, useWatch } from "react-hook-form";
import Graph from "@utils/Graph";

const AbstractMapping = ({
  mappingUrl,
  filterList,
  height = "90%",
  asWidget = false,
  graphId = "graph_per_app",
  title = "",
}) => {
  const location = useLocation();
  const theme = useTheme();
  const [filter, setFilter] = useState({});
  const [elements, setElements] = useState();
  const dataProvider = useDataProvider();
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState();
  const [selectedNode, setSelectedNode] = useState({
    resource: null,
    id: null,
  });
  const [showFooter, setShowFooter] = useState(false);
  const cyRef = useRef();
  const t = useTranslate();

  useEffect(() => {
    dataProvider
      .get(`application-mapping/by-app`)
      .then(({ data }) => {
        setFilter({
          ...filter,
          environment_id: data?.environment_id,
        });
        setLoading(false);
      })
      .catch((error) => {
        setError(error);
        setLoading(false);
      });
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [dataProvider]);

  useEffect(() => {
    const cy = cyRef.current;
    if (!cy) {
      return;
    }
    const graph = new Graph(cy);
    graph.load({
      selector: graphId,
      elements: elements,
      theme: theme,
    });
    graph.cy.on("tap", "node", handleOnTapNode);
    graph.cy.on("tap", (event) => {
      if (event?.target === graph.cy) {
        setShowFooter(false);
      }
    });
  }, [elements, graphId, theme]);

  const handleOnTapNode = (event) => {
    let eltData = event.target.id().split("_");
    const eltId = eltData.pop();
    const resourceName = eltData.join("_");
    setShowFooter(true);

    setSelectedNode({
      resource: resourceName,
      id: eltId,
    });
  };

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
      {!asWidget ? <AppBreadCrumb location={location} /> : null}
      <Typography variant="h3">{title}</Typography>
      <Box
        sx={{
          background: theme.palette.background.default,
          backgroundSize: "40px 40px",
          backgroundImage: `radial-gradient(circle, ${theme.palette.grey[500]} 1px, rgba(0, 0, 0, 0) 1px)`,
          height: height,
          borderRadius: 2,
          borderTopLeftRadius: 0,
          position: "relative",
          border: 4,
          borderColor: theme.palette.secondary.light,
          padding: 0,
          m: 0,
          mt: 1,
          p: 0,
        }}
      >
        <Card
          sx={{
            maxWidth: "15rem",
            borderTopRightRadius: 0,
            borderTopLeftRadius: 2,
            borderBottomLeftRadius: 0,
            borderBottomRightRadius: 2,
            mt: 0,
            p: asWidget ? 0.5 : 1,
            pt: 0,
            position: "absolute",
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
              ".MuiFormControl-root": {
                minWidth: "13rem",
                maxWidth: "100%",
              },
              height: asWidget ? "3.5rem" : "auto",
            }}
          >
            <SimpleForm
              toolbar={null}
              sx={{ p: asWidget ? 0 : "0.5rem 0", width: "100%" }}
            >
              <MappingFilters
                mappingUrl={mappingUrl}
                filterList={filterList}
                defaultFilter={filter}
                setElements={setElements}
                dataProvider={dataProvider}
                setError={setError}
                asWidget={asWidget}
              />
            </SimpleForm>
          </CardContent>
          {!asWidget ? (
            <CardActions
              sx={{
                fontStyle: "italic",
              }}
            >
              <Typography variant="caption">
                {t(
                  "Use the contextual menu to access to the detail of each node."
                )}
                <br />({t("Left click 2s or right click")})
              </Typography>
            </CardActions>
          ) : null}
        </Card>
        <CytoscapeComponent
          id={graphId}
          cy={(cy) => {
            cyRef.current = cy;
          }}
          elements={[]}
          layout={Graph.baseLayoutConfig}
          style={{ width: "100%", height: "100%" }}
        />
        {selectedNode?.id &&
          selectedNode?.resource === "service_instances" &&
          showFooter ? (
          <Card
            sx={{
              background: theme.palette.background.paper,
              width: "100%",
              borderTopRightRadius: 0,
              borderTopLeftRadius: 0,
              borderBottomLeftRadius: theme?.shape?.borderRadius,
              borderBottomRightRadius: theme?.shape?.borderRadius,
              mt: 0,
              p: 0,
              position: "absolute",
              bottom: 0,
              left: 0,
              zIndex: 1,
              opacity: 0.96,
            }}
          >
            <CardContent
              sx={{
                p: 1,
                m: 0,
                color: theme.palette.primary.contrastText,
              }}
            >
              <DetailFooter {...selectedNode} setShowFooter={setShowFooter} />
            </CardContent>
          </Card>
        ) : null}
      </Box>
    </>
  );
};

const MappingFilters = ({
  mappingUrl,
  filterList,
  defaultFilter,
  setElements,
  dataProvider,
  setError,
  asWidget,
}) => {
  useFormContext();
  const watchFields = useWatch([...filterList]);
  const t = useTranslate();
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const [showFilters, setShowFilters] = useState(!isSmall);

  const refreshGraph = useCallback(
    (filterParams) => {
      dataProvider
        .get(mappingUrl, filterParams)
        .then(({ data }) => {
          setElements(data);
        })
        .catch((error) => {
          setError(error);
        });
    },
    [dataProvider, mappingUrl, setElements, setError]
  );

  useEffect(() => {
    if (watchFields?.length === 0) {
      return;
    }
    refreshGraph(watchFields);
  }, [watchFields, refreshGraph]);

  useEffect(() => {
    if (!defaultFilter?.environment_id) {
      return;
    }
    refreshGraph({
      environment_id: defaultFilter?.environment_id,
      application_id: [],
      team_id: [],
    });
  }, [defaultFilter, refreshGraph]);

  if (asWidget)
    return (
      <ReferenceInput source="environment_id" reference="environments">
        <SelectInput
          isRequired={true}
          optionText="name"
          defaultValue={defaultFilter?.environment_id}
        />
      </ReferenceInput>
    );

  return (
    <>
      <Stack direction="row" alignItems="center" justifyContent="center" spacing={2} sx={{ width: '100%' }}>
        <Button
          variant="outlined"
          startIcon={showFilters ? <FilterListIcon /> : <FilterListOffIcon />}
          onClick={() => { setShowFilters(!showFilters) }}
        >
          Filters
        </Button>
      </Stack>
      <Collapse in={showFilters}>
        <ReferenceInput source="environment_id" reference="environments">
          <SelectInput
            isRequired={true}
            optionText="name"
            defaultValue={defaultFilter?.environment_id}
          />
        </ReferenceInput>
        {filterList.includes("application_id") ? (
          <ReferenceArrayInput source="application_id" reference="applications">
            <SelectArrayInput optionText="name" />
          </ReferenceArrayInput>
        ) : null}
        {filterList.includes("team_id") ? (
          <ReferenceArrayInput source="team_id" reference="teams">
            <SelectArrayInput optionText="name" />
          </ReferenceArrayInput>
        ) : null}
        {filterList.includes("hosting_id") ? (
          <ReferenceArrayInput source="hosting_id" reference="hostings">
            <SelectArrayInput optionText="name" />
          </ReferenceArrayInput>
        ) : null}
        <Typography variant="h6">{t("Dependency level")}</Typography>
        {Object.values(serviceInstanceDepLevel).map((level, index) => (
          <Tooltip key={index} title={level?.description}>
            <Tag
              label={level.label}
              color={level?.color}
              size="small"
              component="span"
              sx={{
                p: 0,
                //height: "100%",
                cursor: "inherit",
                width: "8rem",
              }}
            />
          </Tooltip>
        ))}
      </Collapse>
    </>
  );
};

const DetailFooter = memo(({ resource, id, setShowFooter }) => {
  const theme = useTheme();
  const { isLoading, error, record } = useShowController({
    resource: resource,
    id: id,
  });
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
    <Grid
      container
      direction="row"
      justifyContent="space-between"
      alignItems="stretch"
      spacing={0}
    >
      <Grid item xs={12}>
        <Grid
          container
          spacing={0}
          justifyContent="space-between"
          alignItems="stretch"
        >
          <Typography variant="h5" sx={{ color: theme.palette.text.primary }}>
            {record?.service_name} (id: {record?.id})
          </Typography>
          <IconButton onClick={() => setShowFooter(false)}>
            <CloseIcon sx={{ fontSize: "small" }} />
          </IconButton>
        </Grid>
      </Grid>
      <Grid item xs={4}>
        <TextField
          fullWidth
          inputProps={{ readOnly: true }}
          label={t("resources.service_instances.fields.service_version")}
          defaultValue={record?.service_version}
        />
      </Grid>
      <Grid item xs={4}>
        <TextField
          fullWidth
          inputProps={{ readOnly: true }}
          label={t("resources.service_instances.fields.application_name")}
          defaultValue={record?.application_name}
        />
      </Grid>
      <Grid item xs={4}>
        <TextField
          fullWidth
          inputProps={{ readOnly: true }}
          label={t("resources.service_instances.fields.hosting_name")}
          defaultValue={record?.hosting_name}
        />
      </Grid>
    </Grid>
  );
});

export default AbstractMapping;
