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

import { grey } from "@mui/material/colors";
import { styled } from "@mui/system";
import { List } from "react-admin";

const DefaultList = styled(List, {
  shouldForwardProp: () => true,
})(({ theme }) => ({
  "& .MuiButton-startIcon": {
    color: grey[600],
  },
  "& .MuiButtonBase-root": {
    color: grey[600],
  },
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
