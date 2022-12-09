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

const applicationFilters = [
  <TextInput label="Search" source="q" alwaysOn variant="outlined" />,
  <ReferenceInput
    label="Team"
    source="team_id"
    reference="teams"
    sort={{ field: "name", order: "ASC" }}
  >
    <SelectInput optionText="name" variant="outlined" />
  </ReferenceInput>,
];

const ApplicationList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const theme = useTheme();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Application</Typography>
      <List
        {...props}
        filters={applicationFilters}
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
            <ReferenceField source="team_id" reference="teams">
              <TextField source="name" />
            </ReferenceField>
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </List>
    </>
  );
};

export default ApplicationList;
