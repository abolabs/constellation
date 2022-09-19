import { defaultTheme } from 'react-admin';

const appTheme = {
    ...defaultTheme,
    palette: {
        primary: {
          main: '#177E89',
          light: '#54aeb9',
          dark: '#00515c',
          contrastText: '#fff',
        },
        secondary: {
          main: '#084c61',
          light: '#41788e',
          dark: '#002437',
          contrastText: '#fff',
        },
        error: {
          main: '#d02536',
          light: '#ff5f60',
          dark: '#970010',
          contrastText: '#fff',
        },
        warning: {
          main: '#ffc857',
          light: '#fffb88',
          dark: '#c89825',
          contrastText: '#000',
        },
        info: {
          main: '#54aeb9',
          light: '#88e0eb',
          dark: '#167e89',
          contrastText: '#000',
        },
        success: {
          main: '#177E89',
          light: '#54aeb9',
          dark: '#00515c',
          contrastText: '#fff',
        },
        contrastThreshold: 3,
        tonalOffset: 0.2,
    },
    spacing: 10,
    typography: {
        // Use the system font instead of the default Roboto font.
        fontFamily: [ 'Nunito', 'sans-serif'].join(','),
    },
};


export default appTheme
