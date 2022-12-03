import { useEffect, useState } from "react";
import {
  Dialog,
  DialogContent,
  DialogTitle,
  IconButton,
} from "@mui/material";
import {
  AutocompleteInput,
  BooleanInput,
  Create,
  ReferenceInput,
  SimpleForm,
  TextInput,
  useCreate,
  useNotify,
} from "react-admin";
import CloseIcon from '@mui/icons-material/Close';
import { useFormContext, useWatch } from "react-hook-form";
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';

import AlertError from "@components/alerts/AlertError";
import OptionalFieldTitle from "@components/form/OptionalFieldTitle";

const CreateInstanceModal = ({applicationData, environnementId, handleClose, open = false}) => {
  const [create, { isLoading }] = useCreate();
  const notify = useNotify();
  const [defaultValues, setDefaultValues] = useState({});
  const [lastError, setLastError] = useState();

  const onSuccess = (data) => {
    notify(`Instance de service créée`, { type: 'success' })
    handleClose();
  };

  const handleSubmit =  async(data) => {
    data.application_id = applicationData?.id;
    setDefaultValues(data);
    try{
      await create('service_instances', {data: data}, { returnPromise: true });
      setDefaultValues({});
      onSuccess();
      setLastError(null);
    } catch (error) {
      setLastError(error);
      console.error(error);
    }
  };

  const serviceOptionText = (data) =>  `#${data.id} - ${data.name}`;

  const hostingOptionText = (data) =>  `#${data.id} - ${data.name}`;

  const schema = yup.object()
    .shape({
        service: yup.number()
          .required('Please select a service')
          .typeError('Please select a service'),
        service_version_id: yup.number()
          .required('Please select a service version')
          .typeError('Please select a service version'),
        environnement_id: yup.number()
          .required('Please select an environment')
          .typeError('Please select an environment'),
        hosting_id: yup.number()
          .required('Please select an hosting')
          .typeError('Please select an hosting'),
        url: yup.string().nullable().url().max(255),
        role: yup.string().nullable().max(255),
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
        Ajouter une nouvelle instance de service
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
        <Create resource="service_instances">
          <SimpleForm
            resolver={yupResolver(schema)}
            onSubmit={handleSubmit}
            defaultValues={defaultValues}
            sx={{padding: "0 2rem"}}
          >
            <ReferenceInput source="service" reference="services" sort={{field:"name", order:"ASC"}} >
              <AutocompleteInput label="Service" optionText={serviceOptionText} fullWidth/>
            </ReferenceInput>

            <ServiceVersionInput />

            <ReferenceInput source="environnement_id" reference="environnements" sort={{field:"name", order:"ASC"}} >
              <AutocompleteInput label="Environnement" optionText="name" defaultValue={environnementId} fullWidth/>
            </ReferenceInput>

            <ReferenceInput source="hosting_id" reference="hostings" sort={{field:"name", order:"ASC"}} >
              <AutocompleteInput label="Hébergement" optionText={hostingOptionText} fullWidth/>
            </ReferenceInput>

            <TextInput source="url" label={<OptionalFieldTitle label="Url" />} fullWidth/>

            <TextInput source="role" label={<OptionalFieldTitle label="Role" />} fullWidth/>

            <BooleanInput label="Statut" source="statut" defaultValue={true}/>
          </SimpleForm>
        </Create>
      </DialogContent>
    </Dialog>
  );
};

const ServiceVersionInput = () => {
  const { resetField } = useFormContext();
  const service = useWatch({ name: 'service' });

  useEffect(() => {
    resetField('service_version_id');
  }, [service, resetField]);

  return (
    <ReferenceInput source="service_version_id" reference="service_versions" filter={{ service_id: service }}>
      <AutocompleteInput label="Version du service" optionText="version" fullWidth/>
    </ReferenceInput>
  );
}

export default CreateInstanceModal;
