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

import { Stack, Alert, AlertTitle } from "@mui/material";
import he from "he";
import { useTranslate } from "react-admin";

const AlertError = ({ error }) => {
  const t = useTranslate();
  let errorMsg = t("Internal error");

  if (typeof error === "object") {
    errorMsg = error?.response?.data?.message
      ? he.decode(error?.response?.data?.message)
      : "Internal error";
  } else if (typeof error === "string") {
    errorMsg = error;
  }
  return (
    <Stack sx={{ width: "100%" }} spacing={2}>
      <Alert
        severity="error"
        sx={{
          borderRadius: 0,
        }}
      >
        <AlertTitle>{t('Error')}</AlertTitle>
        {errorMsg}
      </Alert>
    </Stack>
  );
};

export default AlertError;
