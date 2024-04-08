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

import * as React from "react";
import { useState, useEffect } from "react";
import { Link, useLogin, useNotify, useTranslate } from "react-admin";
import { useLocation } from "react-router-dom";

import Button from "@mui/material/Button";
import CssBaseline from "@mui/material/CssBaseline";
import TextField from "@mui/material/TextField";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import { createTheme, ThemeProvider } from "@mui/material/styles";
import {
  Container,
  Dialog,
  DialogActions,
  DialogContent,
  DialogContentText,
  DialogTitle,
} from "@mui/material";

import LightTheme from "@themes/LightTheme";
import Copyright from "@components/Copyright";
import Logo from "@components/Logo";

const LoginPage = () => {
  const [email, setEmail] = useState(window?.env?.IS_DEMO ? "demo@abolabs.fr" : "");
  const [password, setPassword] = useState(window?.env?.IS_DEMO ? "demo" : "");
  const login = useLogin();
  const notify = useNotify();
  const location = useLocation();
  const [openNoAccountModal, setOpenNoAccountModal] = useState(false);
  const t = useTranslate();

  const handleClickOpenNoAccountModal = () => {
    setOpenNoAccountModal(true);
  };

  const handleCloseNoAccountModal = () => {
    setOpenNoAccountModal(false);
  };

  useEffect(() => {
    if (location?.state?.notification) {
      notify(location?.state?.notification?.message, {
        type: location?.state?.notification?.type,
      });
    }
  }, [location?.state?.notification, notify]);

  const theme = React.useMemo(() => createTheme(LightTheme), []);

  const handleSubmit = (event) => {
    event.preventDefault();
    // will call authProvider.login({ email, password })
    login({ email, password }).catch(() =>
      notify("Invalid email or password", { type: "error" })
    );
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
          <Box
            component="form"
            onSubmit={handleSubmit}
            noValidate
            sx={{ mt: 1 }}
          >
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label={t("Email Address")}
              name="email"
              autoComplete="email"
              autoFocus
              onChange={(e) => setEmail(e.target.value)}
              defaultValue={email}
            />
            <TextField
              margin="normal"
              required
              fullWidth
              name="password"
              label={t("Password")}
              type="password"
              id="password"
              autoComplete="current-password"
              onChange={(e) => setPassword(e.target.value)}
              defaultValue={password}
            />
            {/*
          <FormControlLabel
            control={<Checkbox value="remember" color="primary" />}
            label="Remember me"
          />
          */}
            <Button
              type="submit"
              fullWidth
              variant="contained"
              sx={{ mt: 3, mb: 2 }}
            >
              {t("ra.auth.sign_in")}
            </Button>
            <Grid container>
              <Grid item xs>
                <Link to="/public/password-reset-request" variant="body2">
                  {t("Forgot password?")}
                </Link>
              </Grid>
              <Grid item>
                <Link
                  href="#"
                  variant="body2"
                  onClick={handleClickOpenNoAccountModal}
                >
                  {t("Don't have an account?")}
                </Link>
              </Grid>
            </Grid>
          </Box>
        </Box>
        <Copyright
          sx={{ mt: 8, mb: 4, color: theme.palette.text.contrastText }}
        />
      </Container>
      <Dialog open={openNoAccountModal} onClose={handleCloseNoAccountModal}>
        <DialogTitle>{t("Don't have an account?")}</DialogTitle>
        <DialogContent>
          <DialogContentText sx={{ p: 2 }}>
            {t("Please contact your administrator to request an account.")}
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button onClick={handleCloseNoAccountModal}>
            {t("ra.action.close")}
          </Button>
        </DialogActions>
      </Dialog>
    </ThemeProvider>
  );
};

export default LoginPage;
