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

import { useEffect } from "react";
import {
  AutocompleteInput,
  ReferenceInput,
  useRecordContext,
  useTranslate,
} from "react-admin";
import { useFormContext, useWatch } from "react-hook-form";
import { List, ListItemText } from "@mui/material";

import Tag from "@components/styled/Tag";

const ServiceVersionInput = () => {
  const { resetField } = useFormContext();
  const service = useWatch({ name: "service" });

  useEffect(() => {
    resetField("service_version_id");
  }, [service, resetField]);

  const serviceVersionInputText = (choice) =>
    `${choice.service_name} / Version ${choice.version}`;

  const serviceVersionMatchSuggestion = (_filter, _choice) => true;

  return (
    <ReferenceInput
      source="service_version_id"
      reference="service_versions"
      sort={{ field: "service_name", order: "ASC" }}
    >
      <AutocompleteInput
        ListboxComponent={List}
        optionText={<OptionRenderer />}
        inputText={serviceVersionInputText}
        matchSuggestion={serviceVersionMatchSuggestion}
        fullWidth
      />
    </ReferenceInput>
  );
};

const OptionRenderer = () => {
  const record = useRecordContext();
  const t = useTranslate();
  return (
    <ListItemText
      primary={record.service_name}
      secondary={
        <>
          <Tag
            label={`${t("resources.service_versions.fields.id")}: ${record.id}`}
            component="span"
            color="primary"
            size="small"
            variant="outlined"
          />
          &nbsp;
          <Tag
            label={`${t("resources.service_versions.fields.version")}: ${record.version}`}
            component="span"
            color="primary"
            size="small"
            variant="outlined"
          />
        </>
      }
    />
  );
};

export default ServiceVersionInput;
