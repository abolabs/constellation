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
  Alert,
} from "@mui/material";
import SaveIcon from "@mui/icons-material/Save";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";
import { Link, useLocation } from "react-router-dom";
import {
  LinearProgress,
  SimpleForm,
  useDataProvider,
  useGetIdentity,
  usePermissions,
  useTranslate,
} from "react-admin";

import AppBreadCrumb from "@layouts/AppBreadCrumb";
import AlertError from "@components/alerts/AlertError";
import { FormProvider, useForm, useFormState } from "react-hook-form";
import { useEffect } from "react";

const AccountEdit = () => {
  const location = useLocation();
  const {
    data,
    isLoading: isLoadingIdentity,
    isPending: isPendingIdentity,
    error: getIdentityError,
    refetch,
  } = useGetIdentity();
  const dataProvider = useDataProvider();
  const t = useTranslate();
  const { permissions } = usePermissions();

  const AccountEditSchema = yup
    .object()
    .shape({
      name: yup
        .string()
        .required(t("Full name required"))
        .typeError(t("Full name required"))
        .max(254),
      email: yup
        .string()
        .email()
        .required(t("Please define an email"))
        .typeError(t("Please define an email"))
        .max(254),
      "current-password": yup
        .string()
        .typeError(t("Please confirm the password"))
        .when("email", {
          is: (newEmail) => newEmail !== data?.email,
          then: (schema) =>
            schema.required(t("Please enter your current password to confirm")),
        })
        .max(254),
    })
    .required();

  console.log('data', data, isPendingIdentity)
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
      <AppBreadCrumb location={location} />
      <Typography variant="h3">{t("Profile")}</Typography>
      <FormProvider {...methods}>
        <Card sx={{ mt: 1 }}>
          <CardContent>
            <form action="/account/edit" method="put">
              {!permissions?.includes('edit profile')
                ? <Alert sx={{ mb: 1 }} severity="info" variant="outlined">{t('Profile edition is disabled')}.</Alert>
                : null
              }
              <TextField
                label={t("resources.account.fields.name")}
                error={!!errors?.name}
                helperText={errors?.name?.message}
                fullWidth
                readOnly={!permissions?.includes('edit profile')}
                {...methods.register("name")}
                sx={{ pb: 1 }}
              />
              <TextField
                label={t("resources.account.fields.email")}
                error={!!errors?.email}
                helperText={errors?.email?.message}
                fullWidth
                inputProps={{ readOnly: !permissions?.includes('edit profile') }}
                {...methods.register("email")}
                sx={{ pb: 1 }}
              />
              {dirtyFields?.email ? (
                <TextField
                  label={t("Confirm your password")}
                  type="password"
                  fullWidth
                  inputProps={{ readOnly: !permissions?.includes('edit profile') }}
                  error={!!errors?.["current-password"]}
                  helperText={
                    errors?.["current-password"]?.message ??
                    t("Confirm e-mail change by entering your current password")
                  }
                  {...methods.register("current-password")}
                  sx={{ pb: 1 }}
                />
              ) : null}
              {permissions?.includes('edit profile') ?
                <Link to="/public/password-reset-request">
                  <Button sx={{ mt: 1 }}>{t("Reset the password")}</Button>
                </Link>
                : null
              }
            </form>
          </CardContent>
        </Card>
        <Toolbar variant="dense">
          {permissions?.includes('edit profile') ?
            <Button
              startIcon={<SaveIcon />}
              disabled={!isDirty}
              onClick={methods.handleSubmit(onSubmit)}
            >
              {t("ra.action.save")}
            </Button>
            : null
          }
        </Toolbar>
      </FormProvider>
    </>
  );
};

export default AccountEdit;
