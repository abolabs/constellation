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
  Box,
  Typography,
  TextField,
  Card,
  CardContent,
  Toolbar,
  Button,
} from "@mui/material";
import SaveIcon from "@mui/icons-material/Save";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";
import { useLocation } from "react-router-dom";
import { LinearProgress, useDataProvider, useGetIdentity } from "react-admin";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import { FormProvider, useForm, useFormState } from "react-hook-form";
import { useEffect } from "react";

const AccountEdit = () => {
  const location = useLocation();
  const {
    data,
    isLoading: isLoadingIdentity,
    error: getIdentityError,
    refetch,
  } = useGetIdentity();
  const dataProvider = useDataProvider();

  const AccountEditSchema = yup
    .object()
    .shape({
      name: yup
        .string()
        .required("Full name required.")
        .typeError("Full name required.")
        .max(254),
      email: yup
        .string()
        .email()
        .required("Please define an email.")
        .typeError("Please define an email.")
        .max(254),
      "current-password": yup
        .string()
        .typeError("Please confirm the password.")
        .when("email", {
          is: (newEmail) => newEmail !== data?.email,
          then: (schema) =>
            schema.required("Please enter your current password to confirm."),
        })
        .max(254),
    })
    .required();

  const methods = useForm({
    defaultValues: {
      name: data?.fullName,
      email: data?.email,
    },
    resolver: yupResolver(AccountEditSchema),
  });

  const { errors, isDirty, dirtyFields } = useFormState({
    control: methods?.control,
  });

  useEffect(() => {
    methods.setValue("name", data?.fullName);
    methods.setValue("email", data?.email);
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [data]);

  const onSubmit = async (data) => {
    await dataProvider
      .updateProfile(data)
      .then(() => {
        refetch();
      })
      .catch((errors) => {
        const errorsMsg = Object.entries(errors?.response?.data?.errors);
        for (const [formKey, msg] of errorsMsg) {
          methods.setError(formKey, { type: "custom", message: msg.shift() });
        }
      });
    delete data["current-password"];
    methods.reset(data);
  };

  if (isLoadingIdentity) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (getIdentityError) {
    return <AlertError error={getIdentityError} />;
  }

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Editer le profil</Typography>
      <FormProvider {...methods}>
        <Card sx={{ mt: 1 }}>
          <CardContent>
            <form action="/account/edit" method="put">
              <TextField
                label="Full name"
                error={!!errors?.name}
                helperText={errors?.name?.message}
                fullWidth
                {...methods.register("name")}
              />
              <TextField
                label="Email"
                error={!!errors?.email}
                helperText={errors?.email?.message}
                fullWidth
                {...methods.register("email")}
              />
              {dirtyFields?.email ? (
                <TextField
                  label="Confirm password"
                  type="password"
                  fullWidth
                  error={!!errors?.["current-password"]}
                  helperText={
                    errors?.["current-password"]?.message ??
                    "Confirm e-mail change by entering your current password."
                  }
                  {...methods.register("current-password")}
                />
              ) : null}
            </form>
          </CardContent>
        </Card>
        <Toolbar variant="dense">
          <Button
            startIcon={<SaveIcon />}
            disabled={!isDirty}
            onClick={methods.handleSubmit(onSubmit)}
          >
            Save
          </Button>
        </Toolbar>
      </FormProvider>
    </>
  );
};

export default AccountEdit;
