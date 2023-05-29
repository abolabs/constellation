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

import React, { useState } from "react";
import * as yup from "yup";
import {
  Edit,
  PasswordInput,
  ReferenceArrayInput,
  SelectArrayInput,
  SimpleForm,
  TextInput,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import DefaultEditToolBar from "@/components/toolbar/DefaultEditToolBar";
import AlertError from "@components/alerts/AlertError";
import WithPermission from "@components/WithPermission";

const UserEdit = () => {
  const location = useLocation();
  const [lastError, setLastError] = useState();

  const onError = (error) => {
    setLastError(error);
  };

  const UserEditSchema = yup
    .object()
    .shape({
      name: yup
        .string()
        .required("Please define a team name")
        .typeError("Please define a team name")
        .max(254),
      email: yup
        .string()
        .email()
        .required("Please define an email")
        .typeError("Please define an email")
        .max(254),
      password: yup.string().typeError("Please define a password").max(254),
      "confirm-password": yup
        .string()
        .typeError("Please confirm the password")
        .max(254),
      roles: yup
        .array()
        .ensure()
        .compact()
        .of(yup.number())
        .min(1)
        .required("Please select at least one role")
        .typeError("Please select at least one role"),
    })
    .required();

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">User</Typography>
      <Edit mutationOptions={{ onError }}>
        <>
          {lastError ? <AlertError {...lastError} /> : null}
          <SimpleForm
            resolver={yupResolver(UserEditSchema)}
            toolbar={<DefaultEditToolBar />}
          >
            <TextInput source="name" fullWidth />
            <TextInput source="email" fullWidth />
            <PasswordInput source="password" />
            <PasswordInput source="confirm-password" />
            <ReferenceArrayInput source="roles" reference="roles">
              <SelectArrayInput optionText="name" />
            </ReferenceArrayInput>
          </SimpleForm>
        </>
      </Edit>
    </>
  );
};

const UserEditWithPermission = () => (
  <WithPermission permission="edit users" element={UserEdit} />
);

export default UserEditWithPermission;
