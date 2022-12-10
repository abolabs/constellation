import { useState } from "react";
import {
  Dialog,
  DialogContent,
  DialogTitle,
  IconButton,
} from "@mui/material";
import {
  Create,
  SimpleForm,
  TextInput,
  useCreate,
  useNotify,
} from "react-admin";
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import CloseIcon from '@mui/icons-material/Close';

import AlertError from "@components/alerts/AlertError";

const CreateVersionModal = ({serviceID, handleClose, open = false}) => {
  const [create, { isLoading }] = useCreate();
  const notify = useNotify();
  const [defaultValues, setDefaultValues] = useState({});
  const [lastError, setLastError] = useState();

  const onSuccess = () => {
    notify(`Version ajoutée`, { type: 'success' })
    handleClose();
  };

  const handleSubmit =  async(data) => {
    data.service_id = serviceID;
    setDefaultValues(data);
    try{
      await create('service_versions', {data: data}, { returnPromise: true });
      setDefaultValues({});
      onSuccess();
      setLastError(null);
    } catch (error) {
      setLastError(error);
      console.error(error);
    }
  };
  const schema = yup.object()
    .shape({
        version: yup.string().required(),
    })
    .required();

  if (isLoading) {
    return null;
  }

  return (
    <Dialog
      open={open}
      fullWidth
    >
      <DialogTitle>
        Nouvelle version
        {handleClose ? (
          <IconButton
            aria-label="close"
            onClick={() => {
              setLastError(null);
              setDefaultValues({});
              handleClose();
            }}
            sx={{
              position: 'absolute',
              right: 8,
              top: 8,
              color: (theme) => theme.palette.primary.contrastText,
            }}
          >
            <CloseIcon />
          </IconButton>
        ) : null}
      </DialogTitle>
      <DialogContent sx={{padding: 0}}>
        { lastError ? <AlertError {...lastError} /> : null}
        <Create resource="service_versions">
          <SimpleForm
            resolver={yupResolver(schema)}
            onSubmit={handleSubmit}
            defaultValues={defaultValues}
            sx={{padding: "0 2rem"}}
          >
            <TextInput source="version" label="Version" fullWidth/>
          </SimpleForm>
        </Create>
      </DialogContent>
    </Dialog>
  );
};

export default CreateVersionModal;
