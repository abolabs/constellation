import { defaultTheme } from "react-admin";
import { createTheme } from "@mui/material/styles";
import componentsOverride from "./ComponentsOverride";

const theme = createTheme(
  {
    ...defaultTheme,
    breakpoints: {
      values: {
        xs: 0,
        sm: 600,
        md: 900,
        lg: 1200,
        xl: 1536,
      },
    },
    palette: {
      type: "dark",
      primary: {
        main: "#51a9b9",
        light: "#85dbeb",
        dark: "#0f7a89",
        contrastText: "#fff",
      },
      secondary: {
        main: "#45888e",
        light: "#45888e",
        dark: "#003137",
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
        default: "#181a1b",
        paper: "#454a4d",
      },
      shadows: {
        1: "0rem 1.25rem 1.6875rem 0rem rgba(0, 0, 0, 0.05)",
      },
      text: {
        primary: "rgba(232, 230, 227, 0.95)",
        secondary: "rgba(255, 255, 255, 1)",
        disabled: "#e8e6e3",
        hint: "#e8e6e3",
      },

      divider: "#e8e6e3",
      contrastThreshold: 3,
      tonalOffset: 0.2,
    },
    spacing: 15,
    typography: {
      // Use the system font instead of the default Roboto font.
      fontFamily: ["Nunito", "sans-serif"].join(","),
      fontSize: 12,
      h1: {
        fontSize: "3rem",
        lineHeight: 2,
      },
      h2: {
        fontSize: "2.2rem",
        lineHeight: 1.5,
      },
      h3: {
        fontSize: "1.5rem",
        lineHeight: 1.25,
      },
      h4: {
        fontSize: "1.2rem",
      },
      h5: {
        fontSize: "1.1rem",
      },
      h6: {
        fontSize: "1.0rem",
      },
    },
    shape: {
      borderRadius: 10,
    },
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
