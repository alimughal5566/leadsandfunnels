const path = require('path');

module.exports = {

    entry: path.resolve( __dirname, 'index.js' ),

    output: {
        path: path.resolve( __dirname, '../../../public/lp_assets/theme_admin3/js' ),
        filename: 'sticky-bar.js'
    },

    resolve: {
        alias: {
            '@': path.resolve( __dirname, '.'),
            '@components': path.resolve( __dirname, './components')
        }
    },

    externals: {
        jquery: 'jQuery'
    },

    mode: process.env.NODE_ENV || 'production',

    devtool: 'source-map',

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        plugins: ['lodash'],
                        presets: [
                            [
                              "@babel/preset-env",
                              {
                                useBuiltIns: "entry",
                                corejs: "3.6.5",
                                targets: "ie 10, > 0.25%"
                              }
                            ]
                          ]
                    }
                }
            }
        ]
    },

    watchOptions: {
        ignored: /node_modules/
    },
    
}