const { alias } = require("react-app-rewire-alias");

module.exports = function override(config) {
  alias({
    "@": "src",
    "@components": "src/components",
    "@contexts": "src/contexts",
    "@layouts": "src/layouts",
    "@pages": "src/pages",
    "@providers": "src/providers",
    "@themes": "src/themes",
    "@utils": "src/utils",
  })(config);

  return config;
};
