import {
  Datagrid,
  DateField,
  SimpleList,
  TextField,
  TextInput,
  BulkExportButton,
  ReferenceField,
  ReferenceInput,
  SelectInput,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultList from "@components/styled/DefaultList";

const serviceVersionFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    label="Service"
    source="service_id"
    reference="services"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const ServiceVersionList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service Version</Typography>
      <DefaultList
        {...props}
        filters={serviceVersionFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            primaryText={(record) => "#" + record.id + " - " + record.service_name}
            secondaryText={
              <TextField source="version" />
            }
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <ReferenceField source="service_id" reference="services" >
              <TextField source="name" />
            </ReferenceField>
            <TextField source="version" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

export default ServiceVersionList;
