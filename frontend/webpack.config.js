var path = require('path')
var webpack = require('webpack')


module.exports = {
    entry: './src/main.js',
    output: {
        path: path.resolve(__dirname, './dist'),
        publicPath: '/dist/',
        filename: 'build.js'
    },
    module: {
        rules: [{
                test: /\.scss$/,
                use: [{
                    loader: "style-loader" // creates style nodes from JS strings
                }, {
                    loader: "css-loader" // translates CSS into CommonJS
                }, {
                    loader: "sass-loader" // compiles Sass to CSS
                }]
            },

            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                    loaders: {

                    }


                    // other vue-loader options go here
                }
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[name].[ext]?[hash]'
                }
            }
        ]
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js'
        },
        extensions: ['*', '.js', '.vue', '.json']
    },
    devServer: {
        // historyApiFallback: true,
        noInfo: true,
        overlay: true,
        port: 8080
        // proxy: {
        //     '/api/*': {
        //         target: 'http://localhost:8000',
        //         secure: false,
        //         logLevel: 'debug',
        //         changeOrigin: true
        //       },
        //     '/oauth/*': {
        //         target: 'http://localhost:8000',
        //         changeOrigin: true
        //       },
        // }
    },
    performance: {
        hints: false
    },
    devtool: '#eval-source-map'
}

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map'
        // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            'process.env': {
                NODE_ENV: '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ])
    // module.exports = {
    //     // ...
    //     resolve: {
    //       alias: {
    //         'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
    //       }
    //     }
    //   }
}
module.exports.devServer.proxy = {
    
}

