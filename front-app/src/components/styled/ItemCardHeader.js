import { styled } from "@mui/system";
import { CardHeader } from "@mui/material";

const ItemCardHeader = styled(CardHeader, {
  shouldForwardProp: () => true,
})({
  padding: "0.7rem 1rem",
  "& .MuiTypography-root": {
    fontSize: "1.0rem"
  }
});

export default ItemCardHeader;
