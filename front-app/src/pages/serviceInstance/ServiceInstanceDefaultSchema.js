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

const ServiceInstanceDefaultSchema = yup.object()
    .shape({
        application_id: yup.number()
          .required('Please select an application')
          .typeError('Please select an application')
          .max(254),
        service_version_id: yup.number()
          .required('Please select a service')
          .typeError('Please select a service'),
        environnement_id: yup.number()
          .required('Please select an environment')
          .typeError('Please select an environment'),
        hosting_id: yup.number()
          .required('Please select a hosting')
          .typeError('Please select a hosting'),
        url: yup.string().nullable().url().max(254),
        role: yup.string().nullable().max(254),
        statut: yup.bool().required()
    })
    .required();

export default ServiceInstanceDefaultSchema;
