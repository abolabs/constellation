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

import { useCallback } from "react";
import { useNavigate } from "react-router-dom";
import {
  Button,
  Card,
  CardActions,
  CardContent,
  List,
  ListItem,
  ListItemText,
  useTheme,
} from "@mui/material";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faGitAlt } from "@fortawesome/free-brands-svg-icons";
import LinkIcon from "@mui/icons-material/Link";

import KeyboardArrowRightIcon from "@mui/icons-material/KeyboardArrowRight";
import Tag from "@components/styled/Tag";
import ItemCardHeader from "@components/styled/ItemCardHeader";
import { Link, useTranslate } from "react-admin";

const ServiceInstanceCard = (instance) => {
  const navigate = useNavigate();
  const theme = useTheme();
  const t = useTranslate();

  const onClick = useCallback(() => {
    navigate(`/service_instances/${instance?.id}/show`);
  }, [instance?.id, navigate]);

  return (
    <Card
      sx={{
        height: "18rem",
      }}
    >
      <ItemCardHeader
        title={instance?.service_name}
        sx={{
          background: theme?.palette?.secondary?.main,
          color: theme?.palette?.secondary?.contrastText,
          height: "3rem",
        }}
        action={
          <Tag
            label={`${t("resources.service_versions.fields.version")} ${instance?.service_version
              }`}
            color="primary"
            size="small"
          />
        }
      />
      <CardContent
        sx={{
          height: "10rem",
          "& .MuiTypography-body1": {
            fontWeight: "bold",
          },
        }}
      >
        <List
          sx={{
            "& .MuiListItem-root": {
              padding: 0,
            },
          }}
        >
          <ListItem sx={{ flexWrap: "wrap" }}>
            <Tag
              label={`${t("resources.service_instances.fields.id")}: ${instance?.id
                }`}
              color="primary"
              size="small"
            />
            &nbsp;
            <Tag
              label={`${t("resources.service_instances.fields.statut")}: ${instance?.statut ? "Active" : "Inactive"
                }`}
              color={instance?.statut ? "success" : "warning"}
              size="small"
            />
            &nbsp;
            {instance?.service_git_repo ? (
              <Link
                to={instance?.service_git_repo}
                target="_blank"
                rel="noopener"
              >
                <Tag
                  label={t("resources.services.fields.git_repo")}
                  icon={<FontAwesomeIcon icon={faGitAlt} />}
                  size="small"
                  sx={{ cursor: "pointer" }}
                />
              </Link>
            ) : null}
            &nbsp;
            {instance?.url ? (
              <Link to={instance?.url} target="_blank" rel="noopener">
                <Tag
                  label={t("resources.service_instances.fields.url")}
                  icon={<LinkIcon />}
                  size="small"
                  sx={{ cursor: "pointer" }}
                />
              </Link>
            ) : null}
            &nbsp;
            {instance?.role ? (
              <Tag
                label={`${t("resources.service_instances.fields.role")}: ${instance?.role
                  }`}
                color="secondary"
                size="small"
              />
            ) : null}
          </ListItem>
          <Link to={`/hostings/${instance?.hosting_id}/show`}>
            <ListItem>
              <ListItemText
                primary={t("resources.service_instances.fields.hosting_name")}
                secondary={instance?.hosting_name}
              />
            </ListItem>
          </Link>
        </List>
      </CardContent>
      <CardActions style={{ justifyContent: "center" }}>
        <Button
          variant="outlined"
          endIcon={<KeyboardArrowRightIcon />}
          onClick={onClick}
        >
          {t("View more")}
        </Button>
      </CardActions>
    </Card>
  );
};

export default ServiceInstanceCard;
