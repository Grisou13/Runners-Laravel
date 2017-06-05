#!/bin/bash

bower install &> /dev/null
$HOME/.yarn/bin/yarn

npm rebuild node-sass 2> /dev/null
node node_modules/gulp/bin/gulp.js --production 2> /dev/null
