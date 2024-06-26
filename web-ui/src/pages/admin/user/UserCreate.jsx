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
import { Box } from "@mui/material";
import {
  Create,
  LinearProgress,
  PasswordInput,
  SelectArrayInput,
  SimpleForm,
  TextInput,
  useGetList,
  useTranslate,
} from "react-admin";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";
import Typography from "@mui/material/Typography";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import DefaultEditToolBar from "@/components/toolbar/DefaultEditToolBar";
import AlertError from "@components/alerts/AlertError";
import WithPermission from "@components/WithPermission";

const UserCreate = () => {
  const location = useLocation();
  const [lastError, setLastError] = useState();
  const t = useTranslate();

  const {
    data: rolesList,
    isLoading,
    error: errorGetRolesList,
  } = useGetList("roles", {
    pagination: { page: 1, perPage: 100 },
    sort: { field: "name", order: "ASC" },
  });

  if (isLoading) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (errorGetRolesList) {
    return <AlertError error={errorGetRolesList} />;
  }

  const onError = (error) => {
    setLastError(error);
  };

  const UserCreateSchema = yup
    .object()
    .shape({
      name: yup
        .string()
        .required(t("Please define a team name"))
        .typeError(t("Please define a team name"))
        .max(254),
      email: yup
        .string()
        .email()
        .required(t("Please define an email"))
        .typeError(t("Please define an email"))
        .max(254),
      password: yup
        .string()
        .required(t("Please define a password"))
        .typeError(t("Please define a password"))
        .max(254),
      "confirm-password": yup
        .string()
        .required(t("Please confirm the password"))
        .typeError(t("Please confirm the password"))
        .max(254),
      roles: yup
        .array()
        .ensure()
        .compact()
        .of(yup.number())
        .min(1)
        .required(t("Please select at least one role"))
        .typeError(t("Please select at least one role")),
    })
    .required();

  return (
    <>
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t('resources.users.name')}</Typography>
      <Create mutationOptions={{ onError }}>
        <>
          {lastError ? <AlertError {...lastError} /> : null}
          <SimpleForm
            resolver={yupResolver(UserCreateSchema)}
            toolbar={<DefaultEditToolBar />}
          >
            <TextInput source="name" fullWidth />
            <TextInput source="email" fullWidth />
            <PasswordInput source="password" />
            <PasswordInput source="confirm-password" />
            <SelectArrayInput
              source="roles"
              optionText="name"
              choices={rolesList}
            />
          </SimpleForm>
        </>
      </Create>
    </>
  );
};

const UserCreateWithPermission = () => (
  <WithPermission permission="create users" element={UserCreate} />
);

export default UserCreateWithPermission;
