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
      Table: {
        styleOverrides: {
          root: {
            boxShadow: "none",
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
      MuiOutlinedInput: {
        styleOverrides: {
          root: {
            "& .MuiOutlinedInput-notchedOutline": {
              borderColor: theme?.palette?.primary?.main,
            },
          },
        },
      },
      RaLayout: {
        styleOverrides: {
          root: {
            "& .RaLayout-content": {
              padding: "0.5rem",
            },
          },
        },
      },
    },
  };
};

export default componentsOverride;
