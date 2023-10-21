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
import { grey, blueGrey } from "@mui/material/colors";
import componentsOverride from "./ComponentsOverride";

const theme = createTheme(
  {
    ...defaultTheme,
    palette: {
      mode: "dark",
      primary: {
        main: "#51d7ee",
      },
      secondary: {
        main: "#0f7b8a",
      },
      error: {
        main: "#DB3A34",
      },
      warning: {
        main: "#ffc857",
      },
      info: {
        main: "#3c4665",
      },
      success: {
        main: "#177E89",
      },
      background: {
        default: grey[900],
        paper: blueGrey[900],
      },
      shadows: {
        1: "0rem 1.25rem 1.6875rem 0rem rgba(255, 255, 255, 0.05)",
      },
      text: {
        primary: "rgba(232, 230, 227, 0.95)",
      },
      divider: "#e8e6e3",
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

const DarkTheme = {
  ...theme,
  ...componentsOverride(theme),
};

export default DarkTheme;
