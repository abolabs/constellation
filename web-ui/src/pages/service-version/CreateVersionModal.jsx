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
import { Dialog, DialogContent, DialogTitle, IconButton } from "@mui/material";
import {
  Create,
  SimpleForm,
  TextInput,
  useCreate,
  useNotify,
  useTranslate,
} from "react-admin";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";
import CloseIcon from "@mui/icons-material/Close";

import AlertError from "@components/alerts/AlertError";

const CreateVersionModal = ({ serviceID, handleClose, open }) => {
  const [create, { isLoading }] = useCreate();
  const notify = useNotify();
  const [defaultValues, setDefaultValues] = useState({});
  const [lastError, setLastError] = useState();
  const t = useTranslate();

  const onSuccess = () => {
    notify("Version added", { type: "success" });
    handleClose();
  };

  const handleSubmit = async (data) => {
    data.service_id = serviceID;
    setDefaultValues(data);
    try {
      await create("service_versions", { data: data }, { returnPromise: true });
      setDefaultValues({});
      onSuccess();
      setLastError(null);
    } catch (error) {
      setLastError(error);
      console.error(error);
    }
  };
  const schema = yup
    .object()
    .shape({
      version: yup.string().required(),
    })
    .required();

  if (isLoading) {
    return null;
  }

  return (
    <Dialog open={open} fullWidth>
      <DialogTitle>
        {t("New version")}
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
      <DialogContent sx={{ padding: 0 }}>
        {lastError ? <AlertError {...lastError} /> : null}
        <Create resource="service_versions">
          <SimpleForm
            resolver={yupResolver(schema)}
            onSubmit={handleSubmit}
            defaultValues={defaultValues}
            sx={{ padding: "0 2rem" }}
          >
            <TextInput source="version" fullWidth />
          </SimpleForm>
        </Create>
      </DialogContent>
    </Dialog>
  );
};

export default CreateVersionModal;
