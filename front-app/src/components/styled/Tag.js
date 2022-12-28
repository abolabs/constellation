import { styled } from "@mui/system";
import { Chip } from "@mui/material";

const Tag = styled(Chip, {
  shouldForwardProp: () => true,
})(({ theme }) => ({
  borderRadius: theme?.shape?.borderRadius,
  height: '1rem',
}));

export default Tag;
