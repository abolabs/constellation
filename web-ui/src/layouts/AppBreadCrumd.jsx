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

import * as React from "react";
import Breadcrumbs from "@mui/material/Breadcrumbs";
import Typography from "@mui/material/Typography";

import Stack from "@mui/material/Stack";
import NavigateNextIcon from "@mui/icons-material/NavigateNext";
import HomeIcon from "@mui/icons-material/Home";
import { Link, useTranslate } from "react-admin";

const AppBreadCrumd = (props) => {
  const routePrefix = "/";
  const t = useTranslate();

  const breadcrumbs = [
    <Link underline="hover" key="route-0" color="inherit" to="/">
      <HomeIcon fontSize="small" />
    </Link>,
  ];

  try {
    const paths = props.location.pathname.split("/");
    var i = 1,
      len = paths.length;
    while (i < len) {
      if (i < len - 1) {
        if (isNaN(paths[i])) {
          breadcrumbs.push(
            <Link
              underline="hover"
              key="route-{i}"
              color="inherit"
              to={routePrefix + paths[i]}
            >
              {["add", "show", "edit", "list", "delete"].includes(paths[i])
                ? t(`ra.action.${paths[i]}`)
                : t(`resources.${paths[i]}.name`)}
            </Link>
          );
        }
      } else {
        breadcrumbs.push(
          <Typography key="3" color="text.primary">
            {["add", "show", "edit", "list", "delete", "create"].includes(
              paths[i]
            )
              ? t(`ra.action.${paths[i]}`)
              : t(`resources.${paths[i]}.name`)}
          </Typography>
        );
      }
      i++;
    }
  } catch (e) {
    console.error(e);
  }

  return (
    <Stack spacing={5}>
      <Breadcrumbs
        sx={{
          lineHeight: 1,
          mb: 1,
          mt: 1,
        }}
        separator={<NavigateNextIcon fontSize="small" />}
        aria-label="breadcrumb"
      >
        {breadcrumbs}
      </Breadcrumbs>
    </Stack>
  );
};

export default AppBreadCrumd;
