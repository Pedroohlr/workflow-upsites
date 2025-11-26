const webpack = require('webpack');
const path = require('path');
const ESLintPlugin = require('eslint-webpack-plugin');

module.exports = {
  mode: 'development',
  entry: {
    mainJS: './src/js/mainJS.js',
    seletric: './src/js/seletric.js',
    slick: './src/js/slick.js',
    scrollreveal: './src/js/scrollreveal.js',
  },
  output: {
    path: path.resolve(__dirname, 'assets/js'),
    publicPath: '/wp-content/themes/frameworkThema/assets/js/',
    filename: '[name].js',
    clean: false,
  },
  externals: {
    jquery: 'jQuery',
  },
  devtool: 'eval-source-map',
  resolve: {
    extensions: ['.js', '.json'],
  },
  plugins: [
    new webpack.IgnorePlugin({
      resourceRegExp: /^\.\/locale$/,
      contextRegExp: /moment$/,
    }),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
    }),
    new ESLintPlugin({
      extensions: ['js'],
      exclude: ['node_modules', 'bower_components', 'vendor'],
      failOnError: false,
      failOnWarning: false,
      overrideConfigFile: 'eslint.config.js',
    }),
  ],
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules|bower_components|vendor/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  stats: {
    colors: true,
    modules: false,
    children: false,
  },
  performance: {
    hints: false,
  },
};
