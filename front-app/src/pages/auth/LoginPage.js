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
import { useState } from "react";
import { useLogin, useNotify } from "react-admin";

import Avatar from "@mui/material/Avatar";
import Button from "@mui/material/Button";
import CssBaseline from "@mui/material/CssBaseline";
import TextField from "@mui/material/TextField";
import Link from "@mui/material/Link";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import Typography from "@mui/material/Typography";
import { createTheme, ThemeProvider } from "@mui/material/styles";
import Copyright from "@components/Copyright";
import { Container, SvgIcon } from "@mui/material";

import LightTheme from "@themes/LightTheme";
import { ReactComponent as Logo } from "@/logo50.svg";

export default function LoginPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const login = useLogin();
  const notify = useNotify();

  const theme = React.useMemo(() => createTheme(LightTheme), []);

  const handleSubmit = (event) => {
    event.preventDefault();
    // will call authProvider.login({ email, password })
    login({ email, password }).catch(() => notify("Invalid email or password"));
  };

  return (
  <ThemeProvider theme={LightTheme}>
    <CssBaseline />
    <Container component="main"
      maxWidth="sm"
      sx={{
        pt: 8,
        height: "100vh",
       }}
    >
      <Box
        sx={{
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          background: theme.palette.background.paper,
          color: theme.palette.text.primary,
          p: 2,
          borderRadius: theme.shape.borderRadius,
        }}
        >
        <Avatar
          sx={{
            m: 1,
            bgcolor: 'primary.main',
            height: '4rem',
            width: '4rem',
          }}
        >
          <SvgIcon component={Logo}
            inheritViewBox
            shapeRendering="path"
            color="primary"
            sx={{
              "path": {
                fill: `${theme.palette.primary.contrastText} !important`,
              },
              height: '80%',
              width: '80%',
            }}
          />
        </Avatar>
        <Typography component="h2" variant="h2">
          Constellation
        </Typography>
        <Typography component="h3" variant="h3">
          Sign in
        </Typography>
        <Box component="form" onSubmit={handleSubmit} noValidate sx={{ mt: 1 }}>
          <TextField
            margin="normal"
            required
            fullWidth
            id="email"
            label="Email Address"
            name="email"
            autoComplete="email"
            autoFocus
            onChange={(e) => setEmail(e.target.value)}
          />
          <TextField
            margin="normal"
            required
            fullWidth
            name="password"
            label="Password"
            type="password"
            id="password"
            autoComplete="current-password"
            onChange={(e) => setPassword(e.target.value)}
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
            Sign In
          </Button>
          <Grid container>
            <Grid item xs>
              <Link href="#" variant="body2">
                Forgot password?
              </Link>
            </Grid>
            <Grid item>
              <Link href="#" variant="body2">
                {"Don't have an account? Sign Up"}
              </Link>
            </Grid>
          </Grid>
        </Box>
      </Box>
      <Copyright sx={{ mt: 8, mb: 4 }} />
    </Container>
  </ThemeProvider>
  );
}
