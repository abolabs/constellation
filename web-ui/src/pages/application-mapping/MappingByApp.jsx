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

import WithPermission from "@components/WithPermission";
import AbstractMapping from "./AbstractMapping";
import { useTranslate } from "react-admin";

const MappingByApp = () => {
  const t = useTranslate();
  return (
    <AbstractMapping
      title={t("Mapping by app")}
      mappingUrl="application-mapping/graph-nodes-app-map"
      filterList={["environment_id", "application_id", "team_id"]}
    />
  );
};

const MappingByAppWithPermission = () => (
  <WithPermission permission="app-mapping" element={MappingByApp} />
);

export default MappingByAppWithPermission;
