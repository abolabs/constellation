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
  Link,
  List,
  ListItem,
  ListItemText,
  useTheme,
} from "@mui/material";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faGitAlt } from '@fortawesome/free-brands-svg-icons'

import KeyboardArrowRightIcon from "@mui/icons-material/KeyboardArrowRight";
import Tag from "@components/styled/Tag";
import ItemCardHeader from "@components/styled/ItemCardHeader";

const ServiceInstanceCard = (instance) => {
  const navigate = useNavigate();
  const theme = useTheme();

  const onClick= useCallback(() => {
    navigate(`/service_instances/${instance?.id}/show`);
  }, [instance?.id, navigate]);

  return (
    <Card sx={{
      height: '15rem',
    }}>
      <ItemCardHeader
        title={instance?.service_name}
        sx={{
          background: theme?.palette?.secondary?.main,
          color: theme?.palette?.secondary?.contrastText,
          height: '3rem'
        }}
        action={
          <Tag
            label={`Version ${instance?.service_version}`}
            color="primary"
            size="small"
          />
        }
      />
      <CardContent sx={{
        height: "60%",
        "& .MuiTypography-body1": {
          fontWeight: "bold",
        }
      }}>
        <List
          sx={{
            "& .MuiListItem-root": {
              padding: 0,
            },
          }}
        >
          <ListItem sx={{flexWrap: "wrap"}}>
            <Tag label={`ID: ${instance?.id}`} color="primary" size="small" />
            &nbsp;
            <Tag
              label={`Statut: ${instance?.statut ? 'Active' : 'Inactive'}`}
              color={instance?.statut ? 'success' : 'warning'}
              size="small"
            />
            &nbsp;
            <Tag
              label={
                <Link href={instance?.url} target="_blank" rel="noopener">
                  <FontAwesomeIcon icon={faGitAlt} />
                  &nbsp;Git url
                </Link>
              }
              size="small"
            />
            &nbsp;
            {instance?.role ? <Tag label={`Role: ${instance?.role}`} color="secondary" size="small" /> : null}
          </ListItem>
          <Link href={`/#/hostings/${instance?.hosting_id}/show`}>
            <ListItem>
              <ListItemText
                primary="Hébergement"
                secondary={instance?.hosting_name}
              />
            </ListItem>
          </Link>
        </List>
      </CardContent>
      <CardActions style={{justifyContent: 'center'}}>
        <Button
          variant="outlined"
          endIcon={<KeyboardArrowRightIcon />}
          onClick={onClick}
        >
          Voir plus
        </Button>
      </CardActions>
    </Card>
  );
};


export default ServiceInstanceCard;
