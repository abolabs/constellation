const { alias } = require('react-app-rewire-alias');

module.exports = function override(config) {
  alias({
    '@': 'src',    
    '@components': 'src/components',
    '@contexts': 'src/contexts',
    '@layouts': 'src/layouts',
    '@pages': 'src/pages',
    '@providers': 'src/providers',    
    '@themes': 'src/themes',    
  })(config);

  return config;
};
