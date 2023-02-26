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
    components: {
      ...theme.components,
      RaDatagrid: {
        styleOverrides: {
          root: {
            //boxShadow: theme.palette.shadows[1],
            boxShadow: "none",
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
            }
          }
        }
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
          }
        }
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
  }
};

export default componentsOverride ;
