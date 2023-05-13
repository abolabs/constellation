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
  TextField,
  Card,
  CardContent,
  Button,
  createTheme,
  ThemeProvider,
  CssBaseline,
  Container,
  Typography,
  CardActions,
} from "@mui/material";
import ArrowBackIosNewIcon from "@mui/icons-material/ArrowBackIosNew";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";

import { FormProvider, useForm, useFormState } from "react-hook-form";
import { useMemo, useState } from "react";
import LightTheme from "@/themes/LightTheme";
import { useNavigate, useSearchParams } from "react-router-dom";

import AuthProvider from "@providers/AuthProvider";
import dataProvider from "@providers/DataProvider";
import AlertError from "@components/alerts/AlertError";
import Logo from "@components/Logo";

const ResetPasswordForm = () => {
  const theme = useMemo(() => createTheme(LightTheme), []);
  const navigate = useNavigate();
  const [searchParams] = useSearchParams();
  const [formError, setFormError] = useState();

  const resetPasswordSchema = yup
    .object()
    .shape({
      email: yup
        .string()
        .email()
        .required("Please define an email.")
        .typeError("Please define an email.")
        .max(254),
      password: yup
        .string()
        .required("Please enter your new password.")
        .typeError("Please enter your new password.")
        .min(8)
        .max(254),
      password_confirmation: yup
        .string()
        .oneOf([yup.ref("password"), null], "Passwords must match")
        .required("Please confirm the password.")
        .typeError("Please confirm the password.")
        .min(8)
        .max(254),
    })
    .required();

  const methods = useForm({
    resolver: yupResolver(resetPasswordSchema),
  });

  const { errors, isDirty } = useFormState({
    control: methods?.control,
  });

  const onSubmit = async (data) => {
    let errorCount = 0;
    await dataProvider
      .resetPassword({ token: searchParams.get("token"), ...data })
      .catch((errors) => {
        errorCount = Object.keys(errors).length;
        if (errors?.response?.data?.message) {
          setFormError(errors?.response?.data?.message);
          return;
        }
        const errorsMsg = Object.entries(errors?.response?.data?.errors);
        for (const [formKey, msg] of errorsMsg) {
          if (
            !["email", "password", "password_confirmation"].includes(formKey)
          ) {
            return setFormError(msg.shift);
          }
          methods.setError(formKey, { type: "custom", message: msg.shift() });
        }
      });
    delete data["password_confirmation"];
    methods.reset(data);
    if (errorCount > 0) {
      return;
    }
    AuthProvider.logout();

    navigate("/login", {
      state: {
        notification: { message: "Password reset!", type: "success" },
      },
    });
  };

  return (
    <ThemeProvider theme={LightTheme}>
      <CssBaseline />
      <Container
        component="main"
        maxWidth="sm"
        sx={{
          pt: 8,
          height: "100vh",
        }}
      >
        <Box
          sx={{
            display: "flex",
            flexDirection: "column",
            alignItems: "center",
            background: theme.palette.background.paper,
            color: theme.palette.text.primary,
            p: 2,
            borderRadius: theme.shape.borderRadius,
          }}
        >
          <Logo />
          <FormProvider {...methods}>
            <Card sx={{ mt: 1 }}>
              <CardContent>
                <Typography gutterBottom variant="h3" component="div">
                  Nouveau mot de passe
                </Typography>
                {formError ? <AlertError error={formError} /> : null}
                <form>
                  <TextField
                    label="Email"
                    error={!!errors?.email}
                    helperText={errors?.email?.message}
                    fullWidth
                    {...methods.register("email")}
                  />
                  <TextField
                    label="New password"
                    type="password"
                    fullWidth
                    error={!!errors?.["password"]}
                    helperText={errors?.["password"]?.message ?? null}
                    {...methods.register("password")}
                  />
                  <TextField
                    label="Confirm password"
                    type="password"
                    fullWidth
                    error={!!errors?.["password_confirmation"]}
                    helperText={
                      errors?.["password_confirmation"]?.message ?? null
                    }
                    {...methods.register("password_confirmation")}
                  />
                </form>
              </CardContent>
            </Card>
            <CardActions>
              <Button
                size="small"
                variant="outlined"
                startIcon={<ArrowBackIosNewIcon />}
                onClick={() => navigate("/login", { replace: true })}
              >
                Cancel
              </Button>
              <Button
                size="small"
                variant="contained"
                disabled={!isDirty}
                onClick={methods.handleSubmit(onSubmit)}
              >
                Envoyer
              </Button>
            </CardActions>
          </FormProvider>
        </Box>
      </Container>
    </ThemeProvider>
  );
};

export default ResetPasswordForm;
