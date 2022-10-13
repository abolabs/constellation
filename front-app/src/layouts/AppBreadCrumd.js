import * as React from 'react';
import Breadcrumbs from '@mui/material/Breadcrumbs';
import Typography from '@mui/material/Typography';
import Link from '@mui/material/Link';
import Stack from '@mui/material/Stack';
import NavigateNextIcon from '@mui/icons-material/NavigateNext';
import HomeIcon from '@mui/icons-material/Home';

export default function AppBreadCrumd(props) {
  const routePrefix = "/#/";

  const breadcrumbs = [
    <Link underline="hover" key="route-0" color="inherit" href="/">
      <HomeIcon fontSize="small" />
    </Link>
  ];

  try {
    const paths = props.location.pathname.split('/');
    var i = 1, len = paths.length;
    while (i < len) {
      if (i < len - 1) {
        breadcrumbs.push(
          <Link underline="hover" key="route-{i}" color="inherit" href={routePrefix+paths[i]}>
            {paths[i]}
          </Link>
        );
      } else {
        breadcrumbs.push(
          <Typography key="3" color="text.primary">
            {paths[i]}
          </Typography>
        );
      }
      i++
    }
  } catch (e) {
    console.log(e);
  }

  return (
    <Stack spacing={2}>
      <Breadcrumbs
        sx={{
          lineHeight: 1,
          mb: 0.5,
        }}
        separator={<NavigateNextIcon fontSize="small" />}
        aria-label="breadcrumb"
      >
        {breadcrumbs}
      </Breadcrumbs>
    </Stack>
  );
}
