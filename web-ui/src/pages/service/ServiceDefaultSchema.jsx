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

import * as yup from "yup";
import i18nProvider from "@providers/I18nProvider";

const ServiceDefaultSchema = yup
  .object()
  .shape({
    name: yup
      .string()
      .required(i18nProvider.translate("Please define a service name"))
      .typeError(i18nProvider.translate("Please define a service name"))
      .max(254),
    git_repo: yup
      .string()
      .required(i18nProvider.translate("Please define a git url"))
      .typeError(i18nProvider.translate("Please define a git url"))
      .url()
      .nullable()
      .max(254),
    team_id: yup
      .number()
      .required(i18nProvider.translate("Please select a team"))
      .typeError(i18nProvider.translate("Please select a team")),
  })
  .required();

export default ServiceDefaultSchema;
