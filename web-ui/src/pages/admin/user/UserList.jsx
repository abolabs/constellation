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
  SimpleList,
  TextField,
  TextInput,
  BulkExportButton,
  ArrayField,
  SingleFieldList,
  useRecordContext,
  useGetOne,
  useTranslate,
} from "react-admin";
import { Chip } from "@mui/material";
import { useMediaQuery } from "@mui/material";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import DefaultToolBar from "@components/toolbar/DefaultToolBar";
import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultList from "@components/styled/DefaultList";
import WithPermission from "@components/WithPermission";
import i18nProvider from "@providers/I18nProvider";

const userFilters = [
  <TextInput label={i18nProvider.translate("ra.action.search")} source="q" alwaysOn variant="outlined" />,
];

const UserList = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const location = useLocation();
  const t = useTranslate();

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t('resources.users.name')}</Typography>
      <DefaultList
        {...props}
        filters={userFilters}
        actions={<DefaultToolBar />}
      >
        {isSmall ? (
          <SimpleList
            linkType="show"
            primaryText={(record) => "#" + record.id + " - " + record.name}
            secondaryText={<TextField source="email" />}
            tertiaryText={(record) =>
              new Date(record.created_at).toLocaleDateString()
            }
          />
        ) : (
          <Datagrid rowClick="show" bulkActionButtons={<BulkExportButton />}>
            <TextField source="id" />
            <TextField source="name" />
            <TextField source="email" />
            <ArrayField source="roles">
              <SingleFieldList>
                <TagsField source="id" />
              </SingleFieldList>
            </ArrayField>
            <DateField source="created_at" />
            <DateField source="updated_at" />
          </Datagrid>
        )}
      </DefaultList>
    </>
  );
};

const TagsField = () => {
  const record = useRecordContext();
  const { data: role, isLoading, error } = useGetOne("roles", { id: record });

  if (isLoading) return null;
  if (error) return null;

  return <Chip key={role.id} label={role.name} />;
};

const UserListWithPermission = (props) => (
  <WithPermission
    permission="view users"
    element={UserList}
    elementProps={props}
  />
);

export default UserListWithPermission;
