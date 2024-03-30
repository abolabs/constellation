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
  usePermissions,
  useTranslate,
} from "react-admin";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultList from "@components/styled/DefaultList";
import WithPermission from "@components/WithPermission";
import i18nProvider from "@providers/I18nProvider";

const hostingFilters = [
  <TextInput
    key="search-filter"
    label={i18nProvider.translate("ra.action.search")}
    source="q"
    alwaysOn
    variant="outlined"
  />,
  <ReferenceInput
    key="hosting-type-filter"
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
  const { permissions } = usePermissions();
  const t = useTranslate();

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t("resources.hostings.name")}</Typography>
      <DefaultList
        {...props}
        filters={hostingFilters}
        actions={
          <DefaultToolBar canCreate={permissions.includes("create hostings")} />
        }
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) => "#" + record.id + " - " + record.name}
            secondaryText={
              <ReferenceField
                source="hosting_type_id"
                reference="hosting_types"
                link={false}
              >
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
            <ReferenceField source="hosting_type_id" reference="hosting_types">
              <TextField source="name" />
            </ReferenceField>
            <TextField source="localisation" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const HostingListWithPermission = (props) => (
  <WithPermission
    permission="view hostings"
    element={HostingList}
    elementProps={props}
  />
);

export default HostingListWithPermission;
