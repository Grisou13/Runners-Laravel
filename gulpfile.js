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
              'process.env': {
                  'NODE_ENV': JSON.stringify(process.env.NODE_ENV ? process.env.NODE_ENV : "development")
              }
            })
        ]
    });
    // console.log(elixir.webpack)

});
function parseINIString(data){
    var regex = {
        section: /^\s*\[\s*([^\]]*)\s*\]\s*$/,
        param: /^\s*([^=]+?)\s*=\s*(.*?)\s*$/,
        comment: /^\s*;.*$/
    };
    var value = {};
    var lines = data.split(/[\r\n]+/);
    var section = null;
    lines.forEach(function(line){
        if(regex.comment.test(line)){
            return;
        }else if(regex.param.test(line)){
            var match = line.match(regex.param);
            if(section){
                value[section][match[1]] = match[2];
            }else{
                value[match[1]] = match[2];
            }
        }else if(regex.section.test(line)){
            var match = line.match(regex.section);
            value[match[1]] = {};
            section = match[1];
        }else if(line.length == 0 && section){
            section = null;
        };
    });
    return value;
}
const fs = require("fs")

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
    mix .webpack("resources/assets/js/api.js","public/js/api.js")
    mix.browserSync({
        proxy: parseINIString(fs.readFileSync("./.env",{encoding:"UTF8"}))["APP_URL"],
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
