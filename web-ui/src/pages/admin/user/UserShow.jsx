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
  ArrayField,
  DateField,
  LinearProgress,
  Show,
  SingleFieldList,
  TextField,
  useGetOne,
  useRecordContext,
  useShowController,
  useTranslate,
} from "react-admin";
import { useLocation } from "react-router-dom";
import { Box, Chip, Typography } from "@mui/material";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";
import WithPermission from "@components/WithPermission";

const UserShow = () => {
  const location = useLocation();
  const { error, isLoading } = useShowController();
  const t = useTranslate();

  if (isLoading) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (error) {
    return <AlertError error={error} />;
  }

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t('resources.users.name')}</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout>
          <TextField source="id" />
          <TextField source="name" />
          <TextField source="email" />
          <ArrayField source="roles">
            <SingleFieldList sx={{ p: 1 }}>
              <TagsField source="id" />
            </SingleFieldList>
          </ArrayField>
          <DateField source="created_at" />
          <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
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

const UserShowWithPermission = () => (
  <WithPermission permission="view users" element={UserShow} />
);

export default UserShowWithPermission;
