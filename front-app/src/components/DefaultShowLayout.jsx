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

import { LinearProgress, SimpleShowLayout, useShowContext } from "react-admin";
import {
  Box,
  Card,
  CardContent,
  Grid,
} from "@mui/material";

import DefaultCardHeader from "@components/styled/DefaultCardHeader";
import AlertError from "@components/alerts/AlertError";

const DefaultShowLayout = ({title=null, canDelete=true, canEdit=true, children}) => {
  const { error, isLoading, record, resource } = useShowContext();

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
    <Box sx={{ flexGrow: 1 }}>
      <Grid container>
        <Grid item xs={12}>
          <Card>
            <DefaultCardHeader
              object={resource}
              record={record}
              title={title || record?.name}
              canDelete={canDelete}
              canEdit={canEdit}
            />
            <CardContent
              sx={{
                "& .RaLabeled-label": {
                  fontWeight: "bold",
                }
              }}
            >
                <SimpleShowLayout>
                  {children}
                </SimpleShowLayout>
            </CardContent>
          </Card>
        </Grid>
      </Grid>
    </Box>
  );
};

export default DefaultShowLayout;
