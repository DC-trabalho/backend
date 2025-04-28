import vue from 'eslint-plugin-vue';
import prettier from 'eslint-config-prettier';
import { defineFlatConfig } from 'eslint-define-config';

export default defineFlatConfig([
  {
    ignores: [
      'vendor',
      'node_modules',
      'public',
      'bootstrap/ssr',
      'tailwind.config.js',
      'resources/js/components/ui/*',
    ],
  },
  {
    plugins: {
      vue,
    },
    rules: {
      'vue/multi-word-component-names': 'off',
    },
  },
  prettier,
]);
