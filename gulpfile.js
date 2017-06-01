var elixir = require('laravel-elixir');
var webpack = require("webpack")
require('laravel-elixir-vue-2');
// require('laravel-elixir-webpack-react');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */
elixir.ready(function() {
    elixir.webpack.mergeConfig({
        babel: {
            presets: ['react',"es2017", 'es2015', 'stage-1'],
            plugins: ["transform-decorators-legacy"]
        },
        module: {
            loaders: [
                {
                    // use babel-loader for *.js and *.jsx files
                    test: /\.jsx?$/,
                    exclude: /node_modules/,
                    loader: 'babel'
                }
            ]
        },
        resolve: {
            extensions: ['', '.js', '.json', '.jsx' ]
        },
        plugins: [
            new webpack.DefinePlugin({
                'process.env.NODE_ENV': JSON.stringify(elixir.config.production ? "production":"dev")
            })
        ]
    });
    // console.log(elixir.webpack)

});

elixir((mix) => {

    mix .sass('app.scss')
        .sass("print.scss")
        .sass("pdf.sass")
        .webpack('app.js');
    mix .copy("./node_modules/sweetalert/dist/sweetalert.min.js","public/js/sweetalert.js")
    mix .copy("./node_modules/sweetalert/dist/sweetalert.css","public/css/sweetalert.css")
    mix .copy("./node_modules/typeahead.js/dist/typeahead.bundle.min.js","public/js/typeahead.js")
    mix.copy('resources/assets/fonts/**/*', 'public/fonts/');
    mix .webpack("resources/assets/js/runs/app.js","public/js/runs.js")
    mix.browserSync({
        proxy: "192.168.10.10",
        socket: {
            namespace: '/bsync'
        }
    });
    // if (mix.config.inProduction) {
    //     mix.version();
    // }
    // mix.webpack("runs.js");
    // mix.webpack('runs/app.js', 'public/js/runs.js');
    // mix.webpack('runs/display.jsx', 'public/js/run-display.js');
    //mix.combine(["/resources/assets/js/typeahead.bundle.min.js",'/resources/assets/js/runs.js'], 'public/js/run-searcher.js');
});
