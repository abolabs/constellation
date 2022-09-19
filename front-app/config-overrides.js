const { alias } = require('react-app-rewire-alias');

module.exports = function override(config) {
  alias({
    '@': 'src',
    '@pages': 'src/pages',
    '@components': 'src/components',
    '@providers': 'src/providers',
    '@layouts': 'src/layouts',
    '@themes': 'src/themes',
  })(config);

  return config;
};
