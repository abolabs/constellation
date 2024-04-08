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
