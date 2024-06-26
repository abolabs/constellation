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
import { Dialog, DialogContent, DialogTitle, IconButton, useMediaQuery, useTheme, ListItemText } from "@mui/material";
import {
  AutocompleteInput,
  BooleanInput,
  Create,
  ReferenceInput,
  SimpleForm,
  TextInput,
  useCreate,
  useNotify,
  usePermissions,
  useRecordContext,
  useRefresh,
  useTranslate,
} from "react-admin";
import CloseIcon from "@mui/icons-material/Close";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";

import AlertError from "@components/alerts/AlertError";
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";
import ServiceVersionInput from "./ServiceVersionInput";
import Tag from "@components/styled/Tag";

const CreateInstanceModal = ({
  applicationData,
  environmentId,
  handleClose,
  open = false,
}) => {
  const [create, { isLoading }] = useCreate();
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const notify = useNotify();
  const refresh = useRefresh();
  const [defaultValues, setDefaultValues] = useState({});
  const [lastError, setLastError] = useState();
  const { permissions } = usePermissions();
  const t = useTranslate();
  const theme = useTheme();

  if (!permissions.includes("create service_instances")) {
    return null;
  }

  const onSuccess = (_data) => {
    notify("Service instance created", { type: "success" });
    handleClose();
    refresh();
  };

  const handleSubmit = async (data) => {
    data.application_id = applicationData?.id;
    setDefaultValues(data);
    try {
      await create(
        "service_instances",
        { data: data },
        { returnPromise: true }
      );
      setDefaultValues({});
      onSuccess();
      setLastError(null);
    } catch (error) {
      setLastError(error);
      console.error(error);
    }
  };

  const HostingOptionText = () => {
    const t = useTranslate();
    const record = useRecordContext();

    return (
      <ListItemText
        primary={record.name}
        secondary={
          <>
            <Tag
              label={`${t("resources.hostings.fields.id")}: ${record.id}`}
              component="span"
              color="primary"
              size="small"
              variant="outlined"
            />
            &nbsp;
            <Tag
              label={`${record.hosting_type_name}`}
              component="span"
              color="primary"
              size="small"
              variant="outlined"
            />
            &nbsp;
            <Tag
              label={`${record.localisation}`}
              component="span"
              color="primary"
              size="small"
              variant="outlined"
            />
          </>
        }
      />
    )
  };

  const schema = yup
    .object()
    .shape({
      service_version_id: yup
        .number()
        .required(t("Please select a service version"))
        .typeError(t("Please select a service version")),
      environment_id: yup
        .number()
        .required(t("Please select an environment"))
        .typeError(t("Please select an environment")),
      hosting_id: yup
        .number()
        .required(t("Please select an hosting"))
        .typeError(t("Please select an hosting")),
      url: yup.string().nullable().url().max(254),
      role: yup.string().nullable().max(254),
    })
    .required();

  if (isLoading) {
    return null;
  }

  return (
    <Dialog open={open} fullWidth fullScreen={isSmall}>
      <DialogTitle>
        {t("Add a new service instance")}
        {handleClose ? (
          <IconButton
            aria-label={t("ra.action.close")}
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
      <DialogContent sx={{ padding: 0, backgroundColor: theme?.palette?.background?.default }}>
        {lastError ? <AlertError {...lastError} /> : null}
        <Create
          resource="service_instances"
          mutationMode="pessimistic"
          sx={{ "& .RaCreate-main": { m: 0 } }}
        >
          <SimpleForm
            resolver={yupResolver(schema)}
            onSubmit={handleSubmit}
            defaultValues={defaultValues}
            sx={{ padding: "0 2rem" }}
          >
            <ServiceVersionInput />

            <ReferenceInput
              source="environment_id"
              reference="environments"
              sort={{ field: "name", order: "ASC" }}
            >
              <AutocompleteInput
                optionText="name"
                defaultValue={environmentId}
                fullWidth
              />
            </ReferenceInput>

            <ReferenceInput
              source="hosting_id"
              reference="hostings"
              sort={{ field: "name", order: "ASC" }}
            >
              <AutocompleteInput
                optionText={<HostingOptionText />}
                inputText={(choice) => `#${choice.id} - ${choice.name}`}
                fullWidth
              />
            </ReferenceInput>

            <TextInput
              source="url"
              label={
                <OptionalFieldTitle
                  label={t("resources.service_instances.fields.url")}
                />
              }
              fullWidth
            />

            <TextInput
              source="role"
              label={
                <OptionalFieldTitle
                  label={t("resources.service_instances.fields.role")}
                />
              }
              fullWidth
            />

            <BooleanInput source="statut" defaultValue={true} />
          </SimpleForm>
        </Create>
      </DialogContent>
    </Dialog>
  );
};

export default CreateInstanceModal;
