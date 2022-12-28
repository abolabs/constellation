import { DeleteWithConfirmButton } from "react-admin";
import { useNavigate } from "react-router-dom";
import {
  Button,
  CardHeader,
  useTheme,
} from "@mui/material";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import EditIcon from "@mui/icons-material/Edit";

const DefaultCardHeader = (props) => {
  const navigate = useNavigate();
  const theme = useTheme();

  return (
    <CardHeader
      title={props?.title}
      titleTypographyProps={{
        variant: "h5",
      }}
      sx={{
        background: theme?.palette?.primary?.main,
        color: theme?.palette?.primary?.contrastText,
        "& .MuiButton-root": {
          color: theme?.palette?.primary?.contrastText,
        },
      }}
      action={
        <>
          <DeleteWithConfirmButton />
          <Button
            onClick={() => navigate(`/services/${props?.record.id}/edit`)}
          >
            <EditIcon />
            &nbsp;&nbsp;Edit
          </Button>
          <Button onClick={() => navigate(-1)}>
            <ChevronLeftIcon />
            &nbsp;&nbsp;Go back
          </Button>
        </>
      }
      {...props}
    />
  );
}

export default DefaultCardHeader;
