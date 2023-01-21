import {
  Datagrid,
  DateField,
  SimpleList,
  TextField,
  TextInput,
  BulkExportButton,
  NumberField,
  ReferenceInput,
  SelectInput,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultList from "@components/styled/DefaultList";

const auditFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    label="User"
    source="user_id"
    reference="users"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const AuditList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Audit</Typography>
      <DefaultList
        {...props}
        filters={auditFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            primaryText={(record) => `#${record.id} - [${record.auditable_id}- ${record.auditable_type} ]`}
            secondaryText={
              <TextField source="user_name" />
            }
            tertiaryText={(record) =>
              `${record.event} - ${new Date(record.created_at).toLocaleDateString()}`
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <NumberField source="id" />
            <NumberField source="user_name" />
            <TextField source="auditable_id" />
            <TextField source="auditable_type" />
            <TextField source="event" />
            <TextField source="ip" />
            <DateField source="created_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

export default AuditList;
