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
import {
  Dialog,
  DialogContent,
  DialogTitle,
  IconButton,
  List,
  ListItem,
  ListItemAvatar,
  ListItemText,
} from "@mui/material";
import {
  AutocompleteInput,
  Edit,
  RadioButtonGroupInput,
  ReferenceInput,
  SimpleForm,
  TextInput,
  useUpdate,
  useNotify,
  useRecordContext,
  useRefresh,
  Toolbar,
  SaveButton,
} from "react-admin";
import CloseIcon from "@mui/icons-material/Close";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";

import Tag from "@components/styled/Tag";
import AlertError from "@components/alerts/AlertError";
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";

const ServiceInstanceDepEditToolbar = (props) => (
  <Toolbar {...props}>
    <SaveButton />
  </Toolbar>
);

const EditServiceInstanceDepModal = ({
  currentServiceInstanceDep,
  depType,
  sourceServiceInstance,
  handleClose,
  open = false,
}) => {
  const [update, { isLoading }] = useUpdate();
  const notify = useNotify();
  const [defaultValues, setDefaultValues] = useState({});
  const [lastError, setLastError] = useState();
  const refresh = useRefresh();

  let idsToExclude, sourceFieldName, targetFieldName;

  if (depType === "depend_of") {
    sourceFieldName = "instance_id";
    targetFieldName = "instance_dep_id";
    idsToExclude = sourceServiceInstance?.meta?.instanceDependencies.map(
      (elt) => elt?.instance_dep_id
    );
  } else {
    sourceFieldName = "instance_dep_id";
    targetFieldName = "instance_id";
    idsToExclude = sourceServiceInstance?.meta?.instanceDependenciesSource.map(
      (elt) => elt?.instance_id
    );
  }
  idsToExclude.push(sourceServiceInstance?.id);

  const onSuccess = (_data) => {
    notify(`Dépendance de service modifiée`, { type: "success" });
    handleClose();
  };

  const referenceInputProps = {
    source: targetFieldName,
  };

  const handleSubmit = async (data) => {
    data[sourceFieldName] = sourceServiceInstance?.id;
    setDefaultValues(data);
    try {
      await update(
        "service_instance_dependencies",
        { id: currentServiceInstanceDep?.id, data: data },
        { returnPromise: true }
      );
      setDefaultValues({});
      onSuccess();
      setLastError(null);
      refresh();
    } catch (error) {
      setLastError(error);
      console.error(error);
    }
  };

  const serviceInstanceInputText = (choice) =>
    `${choice?.service_name} ${choice?.application_name}`;
  const serviceInstanceMatchSuggestion = (_filter, _choice) => true;

  const dependencySchema = {};
  dependencySchema[targetFieldName] = yup
    .number()
    .required("Please select a dependency")
    .typeError("Please select a dependency");

  const schema = yup
    .object()
    .shape({
      ...dependencySchema,
      level: yup
        .number()
        .required("Please select a level")
        .typeError("Please select a level"),
      description: yup.string().nullable().max(254),
    })
    .required();

  if (isLoading) {
    return null;
  }

  return (
    <Dialog open={open} fullWidth>
      <DialogTitle>
        Editer la dépendance
        {handleClose ? (
          <IconButton
            aria-label="close"
            onClick={() => {
              setLastError(null);
              setDefaultValues({});
              handleClose();
            }}
            sx={{
              position: "absolute",
              right: 8,
              top: 8,
              color: (theme) => theme.palette.primary.contrastText,
            }}
          >
            <CloseIcon />
          </IconButton>
        ) : null}
      </DialogTitle>
      <DialogContent sx={{ padding: 0 }}>
        {lastError ? <AlertError {...lastError} /> : null}
        <Edit
          resource="service_instance_dependencies"
          id={currentServiceInstanceDep.id}
        >
          <SimpleForm
            toolbar={<ServiceInstanceDepEditToolbar />}
            resolver={yupResolver(schema)}
            onSubmit={handleSubmit}
            defaultValues={defaultValues}
            sx={{ padding: "0 2rem" }}
          >
            <ReferenceInput
              reference="service_instances"
              sort={{ field: "service_version_name", order: "ASC" }}
              filter={{
                environment_id: sourceServiceInstance.environment_id,
                _exclude: {
                  id: idsToExclude,
                },
              }}
              {...referenceInputProps}
            >
              <AutocompleteInput
                label="Service"
                ListboxComponent={List}
                optionText={<OptionRenderer />}
                inputText={serviceInstanceInputText}
                matchSuggestion={serviceInstanceMatchSuggestion}
                fullWidth
              />
            </ReferenceInput>

            <RadioButtonGroupInput
              source="level"
              label="Niveau de dépendance"
              row={false}
              choices={[
                { id: 1, name: "Faible" },
                { id: 2, name: "Majeur" },
                { id: 3, name: "Critique" },
              ]}
            />

            <TextInput
              source="description"
              label={<OptionalFieldTitle label="Description" />}
              multiline
              fullWidth
            />
          </SimpleForm>
        </Edit>
      </DialogContent>
    </Dialog>
  );
};

const OptionRenderer = () => {
  const record = useRecordContext();
  return (
    <ListItem>
      <ListItemAvatar>
        <Tag
          label={`Id: ${record.id}`}
          component="span"
          color="primary"
          size="small"
          variant="outlined"
        />
      </ListItemAvatar>
      <ListItemText
        primary={record.service_name}
        secondary={`Application : ${record.application_name} ${record.environment_name}`}
      />
    </ListItem>
  );
};

export { EditServiceInstanceDepModal };
