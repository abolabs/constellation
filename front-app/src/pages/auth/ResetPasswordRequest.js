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
import EmailIcon from "@mui/icons-material/Email";
import ArrowBackIosNewIcon from "@mui/icons-material/ArrowBackIosNew";
import * as yup from "yup";
import { yupResolver } from "@hookform/resolvers/yup";

import { FormProvider, useForm, useFormState } from "react-hook-form";
import { useMemo } from "react";
import LightTheme from "@/themes/LightTheme";
import { useNavigate } from "react-router-dom";

import AuthProvider from "@providers/AuthProvider";
import dataProvider from "@providers/DataProvider";
import Logo from "@components/Logo";

const ResetPasswordRequest = () => {
  const theme = useMemo(() => createTheme(LightTheme), []);
  const navigate = useNavigate();

  const requestResetPasswordSchema = yup
    .object()
    .shape({
      email: yup
        .string()
        .email()
        .required("Please define an email.")
        .typeError("Please define an email.")
        .max(254),
    })
    .required();

  const methods = useForm({
    resolver: yupResolver(requestResetPasswordSchema),
  });

  const { errors, isDirty } = useFormState({
    control: methods?.control,
  });

  const onSubmit = async (data) => {
    let errorCount = 0;
    await dataProvider.passwordSendResetLink(data).catch((errors) => {
      errorCount = Object.keys(errors).length;
      methods.setError("email", {
        type: "custom",
        message: errors?.response?.data?.message,
      });
    });
    if (errorCount > 0) {
      return;
    }
    AuthProvider.logout();
    navigate("/login", {
      state: { notification: { message: "Email sent!", type: "success" } },
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
                  Réinitialiser votre mot de passe
                </Typography>
                <Typography gutterBottom variant="body2" component="div">
                  Entrer l'e-mail pour envoyer le lien de réinitialisation de
                  mot de passe.
                </Typography>
                <form>
                  <TextField
                    label="Email"
                    error={!!errors?.email}
                    helperText={errors?.email?.message}
                    fullWidth
                    {...methods.register("email")}
                  />
                </form>
              </CardContent>
            </Card>
            <CardActions>
              <Button
                size="small"
                variant="outlined"
                startIcon={<ArrowBackIosNewIcon />}
                onClick={() => navigate(-1, { state: {} })}
              >
                Retour
              </Button>
              <Button
                size="small"
                variant="contained"
                startIcon={<EmailIcon />}
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

export default ResetPasswordRequest;
