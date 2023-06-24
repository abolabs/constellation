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

import * as yup from 'yup';
import i18nProvider from '@providers/I18nProvider';

const HostingTypeDefaultSchema = yup.object()
    .shape({
        name: yup.string()
          .required(i18nProvider.translate('Please define a name'))
          .typeError(i18nProvider.translate('Please define a name'))
          .max(254),
        description: yup.string()
          .required(i18nProvider.translate('Please define a description'))
          .typeError(i18nProvider.translate('Please define a description'))
          .max(254),
    })
    .required();

export default HostingTypeDefaultSchema;
