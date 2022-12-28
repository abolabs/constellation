import {
  Datagrid,
  DateField,
  ReferenceField,
  SimpleList,
  TextField,
  TextInput,
  ReferenceInput,
  SelectInput,
  BulkExportButton,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import DefaultList from "@components/styled/DefaultList";

const servicesFilters = [
  <TextInput key="search_filter" label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    key="team_id"
    label="Team"
    source="team_id"
    reference="teams"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const ServiceList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Service</Typography>
      <DefaultList
        {...props}
        filters={servicesFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            primaryText={(record) => "#" + record.id + " - " + record.name}
            secondaryText={
              <ReferenceField source="team_id" reference="teams" link={false}>
                <TextField source="name" />
              </ReferenceField>
            }
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
              <TextField source="id" />
              <TextField source="name" />
              <TextField source="git_repo" />
              <ReferenceField source="team_id" reference="teams">
                <TextField source="name" />
              </ReferenceField>
              <DateField source="created_at" />
              <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

export default ServiceList;
