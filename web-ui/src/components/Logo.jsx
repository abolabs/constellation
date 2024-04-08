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

import { Avatar, SvgIcon, Typography, useTheme, Box } from "@mui/material";
import { ReactComponent as LogoSvg } from "@/logo50.svg";
import { ReactComponent as GitlabSvg } from "@/gitlab-logo-500.svg";

const Logo = ({ withTitle = true, ...props }) => {
  const theme = useTheme();

  return (
    <>
      <Avatar
        sx={{
          m: 1,
          bgcolor: "primary.main",
          height: "4rem",
          width: "4rem",
        }}
        {...props}
      >
        <SvgIcon
          component={LogoSvg}
          inheritViewBox
          shapeRendering="path"
          color="primary"
          sx={{
            path: {
              fill: `${theme.palette.primary.contrastText} !important`,
            },
            height: "80%",
            width: "80%",
          }}
        />
      </Avatar>
      {withTitle ? (
        <Typography component="h2" variant="h2">
          Constellation
        </Typography>
      ) : null}
    </>
  );
};

export const DrawerLogo = ({ withTitle = true, ...props }) => {
  const theme = useTheme();

  return (
    <Box
      sx={{ display: "inline-flex", p: 0, m: 0, alignItems: "center" }}
    >
      <Avatar
        sx={{
          m: 1,
          bgcolor: "primary.main",
          height: "2rem",
          width: "2rem",
        }}
        {...props}
      >
        <SvgIcon
          component={LogoSvg}
          inheritViewBox
          shapeRendering="path"
          color="primary"
          sx={{
            path: {
              fill: `${theme.palette.primary.contrastText} !important`,
            },
            height: "80%",
            width: "80%",
          }}
        />
      </Avatar>
      {withTitle ? (
        <Typography component="span" variant="h3">
          Constellation
        </Typography>
      ) : null}
    </Box>
  );
};


export default Logo;

export const GitlabLogo = () => (
  <SvgIcon
    component={GitlabSvg}
    inheritViewBox
    shapeRendering="path"
    color="primary"
  />
);

