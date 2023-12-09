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
  ChipField,
  DateField,
  LinearProgress,
  Pagination,
  ReferenceArrayField,
  Show,
  SingleFieldList,
  TextField,
  useShowController,
  useTranslate,
} from "react-admin";
import { useLocation } from "react-router-dom";
import { Box, Typography } from "@mui/material";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";
import WithPermission from "@components/WithPermission";

const RoleShow = () => {
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
      <Typography variant="h3">{t('resources.roles.name')}</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout>
          <TextField source="id" />
          <TextField source="name" />
          <ReferenceArrayField
            source="permissions"
            reference="permissions"
            perPage={20}
            pagination={<Pagination />}
          >
            <SingleFieldList sx={{ p: 1 }}>
              <ChipField source="name" />
            </SingleFieldList>
          </ReferenceArrayField>
          <DateField source="created_at" />
          <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

const RoleShowWithPermission = () => (
  <WithPermission permission="view roles" element={RoleShow} />
);

export default RoleShowWithPermission;
