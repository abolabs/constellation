import { styled } from "@mui/system";
import { List } from "react-admin";

const DefaultList = styled(List, {
  shouldForwardProp: () => true,
})(({ theme }) => ({
  [theme.breakpoints.down("md")]: {
    "& .MuiToolbar-root": {
      background: "none",
    },
  },
  [theme.breakpoints.down("sm")]: {
    "& .MuiToolbar-root": {
      backgroundColor: "none",
      minHeight: "3rem",
    },
  },
  "& .filter-field": {
    [theme.breakpoints.down("md")]: {
      width: "100%",
      "& .MuiFormControl-root": {
        width: "100%",
      },
    },
  },
}));

export default DefaultList;
