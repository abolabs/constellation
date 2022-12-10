import {
  Stack,
  Alert,
  AlertTitle,
} from "@mui/material";
import he from 'he';

const AlertError = (error) => {
  let errorMsg = error;

  if (typeof error === 'object') {
    errorMsg = error?.response?.data?.message ? he.decode(error?.response?.data?.message) : 'Internal error';
  }
  return (
    <Stack sx={{ width: "100%" }} spacing={2}>
      <Alert
        severity="error"
        sx={{
          borderRadius: 0,
         }}
      >
        <AlertTitle>Error</AlertTitle>
        {errorMsg}
      </Alert>
    </Stack>
  );
}

export default AlertError;
