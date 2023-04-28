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

import { defaultTheme } from "react-admin";
import { createTheme } from "@mui/material/styles";
import componentsOverride from "./ComponentsOverride";

const theme = createTheme(
  {
    ...defaultTheme,
    palette: {
      mode: "light",
      primary: {
        main: "#0b5b61",
        light: "#45888e",
        dark: "#003137",
        contrastText: "#fff",
      },
      secondary: {
        main: "#546e7a",
        light: "#819ca9",
        dark: "#29434e",
        contrastText: "#fff",
      },
      error: {
        main: "#d02536",
        light: "#ff5f60",
        dark: "#970010",
        contrastText: "#fff",
      },
      warning: {
        main: "#ffc857",
        light: "#fffb88",
        dark: "#c89825",
        contrastText: "#000",
      },
      info: {
        main: "#54aeb9",
        light: "#88e0eb",
        dark: "#167e89",
        contrastText: "#000",
      },
      success: {
        main: "#177E89",
        light: "#54aeb9",
        dark: "#00515c",
        contrastText: "#fff",
      },
      background: {
        default: "#F7F9FB",
        paper: "#FFFFFF",
      },
      shadows: {
        1: "0rem 1.25rem 1.6875rem 0rem rgba(0, 0, 0, 0.01)",
      },
      text: {
        primary: "#003137",
        secondary: "#004e5c",
        disabled: "rgba(0, 0, 0, 0.38)",
        hint: "rgba(0, 0, 0, 0.38)",
      },
      divider: "rgba(255, 255, 255, 0.12)",
      contrastThreshold: 3,
      tonalOffset: 0.2,
    },
    spacing: 15,
    props: {
      AppBar: {
        color: "#0f7b8a",
      },
    },
  },
  {
    factor: 1,
  }
);

const LightTheme = {
  ...theme,
  ...componentsOverride(theme),
};

export default LightTheme;
