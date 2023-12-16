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
import { Layout } from "react-admin";
import DefaultAppBar from "@layouts/DefaultAppBar";
import AppMenu from "@layouts/AppMenu";
import { ReactQueryDevtools } from "react-query/devtools";
import { useMediaQuery } from "@mui/material";

const AppLayout = (props) => {
  const isSmall = useMediaQuery((theme) => theme.breakpoints.down("md"));
  return (
    <>
      <Layout
        sx={{
          transition: "background-color 1s",
          "& .RaLayout-content": {
            transition: "background-color 1s",
            padding: isSmall ? "0 1rem" : "0 3rem",
          },
          ".RaLayout-appFrame": {
            marginTop: 4,
          },
          ".MuiDrawer-root": {
            height: "auto",
          },
          ".MuiList-root": {
            pt: 0,
            mt: 0,
          },
        }}
        {...props}
        appBar={DefaultAppBar}
        sidebar={AppMenu}
      />
      {process.env.NODE_ENV === "development" ? <ReactQueryDevtools /> : null}
    </>
  )
};

export default AppLayout;
