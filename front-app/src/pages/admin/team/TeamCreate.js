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
  SimpleForm,
  TextInput,
} from "react-admin";
import { yupResolver } from '@hookform/resolvers/yup';
import { useLocation } from 'react-router-dom';
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from '@/components/toolbar/DefaultEditToolBar';
import TeamDefaultSchema from './TeamDefaultSchema';

const TeamCreate = () => {
  const location = useLocation();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Team</Typography>
      <Create>
        <SimpleForm
          resolver={yupResolver(TeamDefaultSchema)}
          toolbar={<DefaultEditToolBar />}
        >
          <TextInput source="name" fullWidth />
          <TextInput source="manager" fullWidth />
        </SimpleForm>
      </Create>
    </>
  );
};

export default TeamCreate;
