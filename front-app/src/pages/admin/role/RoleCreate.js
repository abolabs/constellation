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

import * as React from 'react';
import {
  Create,
  LinearProgress,
  SelectArrayInput,
  SimpleForm,
  TextInput,
  useGetList,
} from "react-admin";
import {
  Box,
} from "@mui/material";
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from '@/components/toolbar/DefaultEditToolBar';
import AlertError from "@components/alerts/AlertError";
import RoleDefaultSchema from './RoleDefaultSchema';

const RoleCreate = () => {
  const location = useLocation();
  const { data: permissionsList, isLoading, error: errorGetPermissionsList } = useGetList(
    'permissions',
    {
        pagination: { page: 1, perPage: 100 },
        sort: { field: 'name', order: 'ASC' }
    }
  );

  if (isLoading) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (errorGetPermissionsList) {
    return <AlertError error={errorGetPermissionsList} />;
  }

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Role</Typography>
      <Create>
        <SimpleForm
          resolver={yupResolver(RoleDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <SelectArrayInput source="permissions" optionValue="name" optionText="name" choices={permissionsList}/>
        </SimpleForm>
      </Create>
    </>
  );
};

export default RoleCreate;
