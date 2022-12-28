import {
  Datagrid,
  DateField,
  List,
  ReferenceField,
  SimpleList,
  TextField,
  TextInput,
  ReferenceInput,
  SelectInput,
  BulkExportButton,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import { useLocation } from "react-router-dom";
import AppBreadCrumd from "@layouts/AppBreadCrumd";
import Typography from "@mui/material/Typography";
import { useTheme } from "@mui/material/styles";

const hostingFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    label="Hosting type"
    source="hosting_type_id"
    reference="hosting_types"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const HostingList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const theme = useTheme();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Hosting</Typography>
      <List
        {...props}
        filters={hostingFilters}
        actions={<DefaultToolBar />}
        sx={{
          [theme.breakpoints.down('md')]: {
            "& .MuiToolbar-root": {
              background: "none",
            }
          },
          [theme.breakpoints.down('sm')]: {
            "& .MuiToolbar-root": {
              backgroundColor: "none",
              minHeight: "3rem",
            }
          },
          "& .filter-field": {
            [theme.breakpoints.down('md')]: {
              width: "100%",
              "& .MuiFormControl-root": {
                width: "100%",
              },

            },
          }
        }}
      >
        {isSmall ? (
          <SimpleList
            primaryText={(record) => "#" + record.id + " - " + record.name}
            secondaryText={
              <ReferenceField source="hosting_type_id" reference="hosting_types" link={false}>
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
            <ReferenceField source="hosting_type_id" reference="hosting_types" >
              <TextField source="name" />
            </ReferenceField>
            <TextField source="localisation" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </List>
    </>
  );
};

export default HostingList;
