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
