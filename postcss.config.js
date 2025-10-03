import postcssPresetEnv from 'postcss-preset-env';
import postcssNested from 'postcss-nested';
import postcssImport from 'postcss-import';
import cssnano from 'cssnano';
import { purgeCSSPlugin } from '@fullhuman/postcss-purgecss';

const isProd = process.env.NODE_ENV === 'production';

export default {
  plugins: [
    postcssImport(),
    postcssNested(),
    postcssPresetEnv({
      stage: 3, // features stage; ajusta según tu riesgo
      autoprefixer: { grid: true },
      features: {
        'custom-properties': true,
        'nesting-rules': true
      }
    }),

    // PurgeCSS solo en producción
    isProd &&
      purgeCSSPlugin({
        content: [
          './**/*.php',
          './**/*.html',
          './assets/js/**/*.js',
          './blocks/**/*.php',
          './blocks/**/*.js',
          './templates/**/*.php'
        ],
        defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
        safelist: {
          standard: [/^is-/, /^has-/, /^wp-/], // añade patrones que quieres preservar
          deep: [/^modal-/, /^slick-/],
          greedy: [/^acf-/, /^wp-block-/]
        }
      }),
    // Minify only in production
    isProd &&
      cssnano({
        preset: 'default'
      })
  ].filter(Boolean)
};
