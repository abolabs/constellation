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

const componentsOverride = (theme) => {
  return {
    breakpoints: {
      ...theme.breakpoints,
      values: {
        xs: 0,
        sm: 600,
        md: 900,
        lg: 1200,
        xl: 1536,
      },
    },
    typography: {
      ...theme.typography,
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
        fontSize: "1.1rem",
      },
      h5: {
        fontSize: "1.05rem",
      },
      h6: {
        fontSize: "1.0rem",
      },
    },
    shape: {
      ...theme.shape,
      borderRadius: 5,
    },
    components: {
      ...theme.components,
      RaDatagrid: {
        styleOverrides: {
          root: {
            //boxShadow: theme.palette.shadows[1],
            boxShadow: "none",
            "& .RaDatagrid-headerCell": {
              backgroundColor: theme.palette.primary.main,
              "& .MuiTableSortLabel-root": {
                color: theme.palette.primary.contrastText,
              },
              "& .Mui-active .MuiTableSortLabel-icon": {
                color: theme.palette.primary.contrastText,
              },
            },
          },
        },
      },
      RaList: {
        styleOverrides: {
          root: {
            "& .MuiTableSortLabel-root": {
              fontSize: 16,
            },
            "& .TableHead > .MuiTableRow-head": {
              borderTop: 1,
              borderColor: "#000",
            },
            "& .MuiTable-root": {
              boxShadow: theme.palette.shadows[1],
            },
            "& .MuiButtonBase-root": {
              color: theme?.palette?.primary?.main,
            },
            "& .MuiTableCell-root": {
              borderBottom: 0,
              lineHeight: 2.5,
            },
          },
        },
      },
      MuiCard: {
        styleOverrides: {
          root: {
            boxShadow: "none",
          },
        },
      },
      MuiDialogTitle: {
        styleOverrides: {
          root: {
            backgroundColor: theme?.palette?.primary?.main,
            color: theme?.palette?.primary?.contrastText,
          },
        },
      },
      MuiOutlinedInput: {
        styleOverrides: {
          root: {
            "& .MuiOutlinedInput-notchedOutline": {
              borderColor: theme?.palette?.primary?.main,
            },
          },
        },
      },
      Table: {
        styleOverrides: {
          root: {
            boxShadow: "none",
          },
        },
      },
    },
    sidebar: {
      width: 200, // The default value is 240
      closedWidth: 40, // The default value is 55
    },
  };
};

export default componentsOverride;
