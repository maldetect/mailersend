module.exports = {
    moduleFileExtensions: ['js', 'jsx', 'json', 'vue'],
    transform: {
      '^.+\\.vue$': 'vue-jest',
      '.+\\.(css|styl|less|sass|scss|png|jpg|ttf|woff|woff2)$':
        'jest-transform-stub',
      '^.+\\.(js|jsx)?$': 'babel-jest'
    },
    moduleNameMapper: {
      '^@/(.*)$': '<rootDir>/resources/js/$1'
    },
    snapshotSerializers: ['jest-serializer-vue'],

    transformIgnorePatterns: ['<rootDir>/node_modules/'],
    setupFiles: ["<rootDir>/resources/js/tests/unit/index.js"]
  };
