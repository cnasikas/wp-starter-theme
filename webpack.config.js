const path = require('path')
const webpack = require('webpack')
const CleanWebpackPlugin = require('clean-webpack-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const Dotenv = require('dotenv-webpack')

const config = require('./config.js')

module.exports = {
  entry: {
    app: path.resolve(__dirname, 'assets/scripts/app.js')
  },
  output: {
    filename: '[name].min.js',
    path: path.resolve(__dirname, 'dist/scripts')
  },
  devtool: 'source-map',
  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.jsx?$/,
        loader: 'standard-loader',
        exclude: /(node_modules|bower_components|vendor|plugins.js)/,
        options: {
          error: false,
          snazzy: true,
          parser: 'babel-eslint'
        }
      },
      {
        test: /\.js$/,
        exclude: [/node_modules/],
        use: [{
          loader: 'babel-loader'
        }]
      },
      {
        test: /\.html$/,
        exclude: [/node_modules/],
        use: [
          {
            loader: 'raw-loader'
          }
        ]
      },
      {
        test: /\.css$/,
        exclude: [/node_modules/],
        use: [
          {
            loader: 'style-loader'
          },
          {
            loader: 'css-loader', options: { sourceMap: true }
          }
        ]
      },
      {
        test: /\.scss$/,
        exclude: [/node_modules/],
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            {
              loader: 'css-loader', options: { sourceMap: true }
            },
            {
              loader: 'postcss-loader', options: { sourceMap: true }
            },
            {
              loader: 'sass-loader', options: { sourceMap: true }
            }
          ]
        })
      },
      {
        test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)/,
        use: [
          {
            loader: 'url-loader'
          }
        ]
      }
    ]
  },
  plugins: [
    new Dotenv(),
    new CleanWebpackPlugin(['dist']),
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NamedModulesPlugin(),
    new ExtractTextPlugin({
      filename: '../../dist/styles/main.css',
      allChunks: true
    }),
    new BrowserSyncPlugin({
      host: config.host,
      port: config.port,
      proxy: config.proxy,
      files: [
        {
          match: [
            '**/*.php'
          ]
        }
      ],
      rewriteRules: [
        {
          match: config.urlOverride,
          fn: function (req, res, match) {
            return config.host + ':' + config.port
          }
        }
      ]
    })
  ]
}
