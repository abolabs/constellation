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

import { DateField, LinearProgress, Show, TextField, useShowController } from "react-admin";
import { useLocation } from "react-router-dom";
import {
  Box,
  Typography
} from "@mui/material";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";

const HostingTypeShow = () => {
  const location = useLocation();
  const { error, isLoading } = useShowController();

  if (isLoading) {
    return (
      <Box sx={{ width: "100%" }}>
        <LinearProgress />
      </Box>
    );
  }
  if (error) {
    return <AlertError error={error} />;
  }

  return (
    <>
      <AppBreadCrumd location={location} />
      <Typography variant="h3">Hosting Type</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout>
          <TextField source="id" />
          <TextField source="name" />
          <TextField source="description" />
          <DateField source="created_at" />
          <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

export default HostingTypeShow;
