var elixir = require('laravel-elixir');

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
        }
    });
});

elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js');
    mix.webpack("resources/assets/js/runs/app.js","public/js/runs.js")
    console.log("KAHSJGDJKGAHSD")
    // mix.webpack("runs.js");
    // mix.webpack('runs/app.js', 'public/js/runs.js');
    // mix.webpack('runs/display.jsx', 'public/js/run-display.js');
    //mix.combine(["/resources/assets/js/typeahead.bundle.min.js",'/resources/assets/js/runs.js'], 'public/js/run-searcher.js');
});
