import { Typography } from "@mui/material";

const OptionalFieldTitle = ({label}) => {
  return (
    <>
      {label}&nbsp;
      <Typography component="span" variant="subtitle1" fontSize="0.7rem">
        (optional)
      </Typography>
    </>
  );
};

export default OptionalFieldTitle;
