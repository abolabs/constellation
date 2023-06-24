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

import { createElement } from "react";
import { usePermissions } from "react-admin";
import { Navigate } from "react-router-dom";
import PropTypes from "prop-types";

/**
 * Render element if the user is allow, redirect to the home page if not.
 */
const WithPermission = ({ permission, element, ...elementProps }) => {
  const { permissions } = usePermissions();

  if (permission && !permissions?.includes(permission)) {
    return <Navigate to="/" />;
  }
  if (element) {
    return createElement(element, elementProps);
  }
};

WithPermission.propTypes = {
  permission: PropTypes.string.isRequired,
  element: PropTypes.func.isRequired,
  elementProps: PropTypes.object,
};

export default WithPermission;
