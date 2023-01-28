import {
  Datagrid,
  ReferenceField,
  SimpleList,
  TextField,
  TextInput,
  ReferenceInput,
  SelectInput,
  BulkExportButton,
  BooleanField,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import DefaultList from "@components/styled/DefaultList";

const servicesInstancesFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    label="Hosting"
    source="hosting_id"
    reference="hostings"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
  <ReferenceInput
    label="Environment"
    source="environnement_id"
    reference="environnements"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const ServiceInstanceList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service Instance</Typography>
      <DefaultList
        {...props}
        filters={servicesInstancesFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            primaryText={(record) => "#" + record.id + " - " + record.application_name}
            secondaryText={
              <ReferenceField source="service_version_id" reference="service_versions" link={false}>
                <TextField source="version" />
              </ReferenceField>
            }
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
              <TextField source="id" />
              <TextField source="application_name" />
              <TextField source="service_version_name" />
              <TextField source="service_version" />
              <TextField source="environnement_name" />
              <TextField source="hosting_name" />
              <TextField source="role" />
              <BooleanField source="statut" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

export default ServiceInstanceList;
