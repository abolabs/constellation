import * as React from "react";
import { Layout } from "react-admin";
import DefaultAppBar from "@layouts/DefaultAppBar";
import AppMenu from "@layouts/AppMenu";
import { ReactQueryDevtools } from "react-query/devtools";

const AppLayout = (props) => (
  <>
    <Layout
      sx={{
        transition: "background-color 1s",
        "& .RaLayout-content": {
          transition: "background-color 1s",
          padding: "0 1rem",
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
      menu={AppMenu}
    />
    {process.env.NODE_ENV === "development" ? <ReactQueryDevtools /> : null}
  </>
);

export default AppLayout;
