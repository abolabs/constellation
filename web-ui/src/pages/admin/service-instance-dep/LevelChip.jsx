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

import { Chip } from "@mui/material";
import ErrorIcon from '@mui/icons-material/Error';
import WarningIcon from '@mui/icons-material/Warning';
import InfoIcon from '@mui/icons-material/Info';
import { useRecordContext, useTranslate } from "react-admin";

const LevelChip =  ({ source }) => {
  const record = useRecordContext();
  const t = useTranslate();
  if (!record) return null;
  let color = null;
  let label = "Unknown";
  let icon = null;
  switch (record?.[source]) {
    case 1:
      color = "info";
      label = t('minor');
      icon = <InfoIcon />;
      break;
    case 2:
      color = "warning";
      label = t('major');
      icon = <WarningIcon />;
      break;
    case 3:
      color = "error";
      label = t('critic');
      icon = <ErrorIcon />;
      break;
    default:
      break;
  }

  return <Chip icon={icon} label={label} color={color} />;
};

export default LevelChip;
