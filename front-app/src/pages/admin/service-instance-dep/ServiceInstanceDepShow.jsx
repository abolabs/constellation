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
  DateField,
  LinearProgress,
  NumberField,
  Show,
  TextField,
  WrapperField,
  useShowController,
  useTranslate,
} from "react-admin";
import { Link, useLocation } from "react-router-dom";
import { Box, Typography } from "@mui/material";
import LaunchIcon from "@mui/icons-material/Launch";

import AppBreadCrumd from "@layouts/AppBreadCrumd";
import AlertError from "@components/alerts/AlertError";
import DefaultShowLayout from "@components/DefaultShowLayout";
import LevelChip from "./LevelChip";
import WithPermission from "@components/WithPermission";

const ServiceInstanceDepShow = () => {
  const location = useLocation();
  const { error, isLoading, record } = useShowController();
  const t = useTranslate();

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
      <Typography variant="h3">{t("resources.service_instance_dependencies.name")}</Typography>
      <Show actions={null} sx={{ mt: "1rem" }}>
        <DefaultShowLayout
          title={`${record?.instance_application_name} / ${record?.id} - ${record?.instance_service_name}`}
          canEdit={false}
        >
          <TextField source="id"/>
          <WrapperField label={t("resources.service_instance_dependencies.fields.instance_application_name")}>
            <NumberField source="instance_application_id" />
            &nbsp;-&nbsp;
            <TextField source="instance_application_name" />
            <Link to={`/applications/${record?.instance_application_id}/show`}>
              <LaunchIcon fontSize="small" sx={{ p: 0.1 }} />
            </Link>
          </WrapperField>
          <WrapperField label={t("resources.service_instance_dependencies.fields.instance_service_name")}>
            <NumberField source="instance_id" />
            &nbsp;-&nbsp;
            <TextField source="instance_service_name" />
            &nbsp;
            <Link to={`/service_instances/${record?.instance_id}/show`}>
              <LaunchIcon fontSize="small" sx={{ p: 0.1 }} />
            </Link>
          </WrapperField>
          <WrapperField label={t("resources.service_instance_dependencies.fields.instance_dep_application_name")}>
            <NumberField source="instance_dep_application_id" />
            &nbsp;-&nbsp;
            <TextField source="instance_dep_application_name" />
            <Link to={`/applications/${record?.instance_application_id}/show`}>
              <LaunchIcon fontSize="small" sx={{ p: 0.1 }} />
            </Link>
          </WrapperField>
          <WrapperField label={t("resources.service_instance_dependencies.fields.instance_dep_service_name")}>
            <NumberField source="instance_dep_id" />
            &nbsp;-&nbsp;
            <TextField source="instance_dep_service_name" />
            &nbsp;
            <Link to={`/service_instances/${record?.instance_dep_id}/show`}>
              <LaunchIcon fontSize="small" sx={{ p: 0.1 }} />
            </Link>
          </WrapperField>
          <LevelChip source="level" />
          <DateField source="created_at" />
          <DateField source="updated_at" />
        </DefaultShowLayout>
      </Show>
    </>
  );
};

const ServiceInstanceDepShowWithPermission = () => (
  <WithPermission
    permission="view service_instance_dependencies"
    element={ServiceInstanceDepShow}
  />
);

export default ServiceInstanceDepShowWithPermission;
