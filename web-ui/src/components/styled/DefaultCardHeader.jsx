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

import {
  DeleteWithConfirmButton,
  usePermissions,
  useTranslate,
} from "react-admin";
import { useNavigate } from "react-router-dom";
import { Button, CardHeader, useMediaQuery, useTheme } from "@mui/material";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import EditIcon from "@mui/icons-material/Edit";

const DefaultCardHeader = ({
  object,
  record,
  canDelete = true,
  canEdit = true,
  ...props
}) => {
  const navigate = useNavigate();
  const theme = useTheme();
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  const { permissions } = usePermissions();
  const t = useTranslate();

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
          {canDelete && permissions.includes(`delete ${object}`) ? (
            <DeleteWithConfirmButton label={isSmall ? null : t("ra.action.delete")} />
          ) : null}
          {canEdit && permissions.includes(`edit ${object}`) ? (
            <Button onClick={() => navigate(`/${object}/${record.id}/edit`)}>
              <EditIcon />
              &nbsp;{isSmall ? null : t("ra.action.edit")}
            </Button>
          ) : null}
          <Button onClick={() => navigate(-1)}>
            <ChevronLeftIcon />
            &nbsp;{isSmall ? null : t("ra.action.back")}
          </Button>
        </>
      }
      {...props}
    />
  );
};

export default DefaultCardHeader;
