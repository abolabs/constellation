import * as React from 'react';
import { Layout } from 'react-admin';
import DefaultAppBar from '@layouts/DefaultAppBar';
import AppMenu from '@layouts/AppMenu';

const AppLayout = props => <Layout {...props} appBar={DefaultAppBar} menu={AppMenu} />;

export default AppLayout;
