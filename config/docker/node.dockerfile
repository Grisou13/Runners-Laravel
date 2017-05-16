FROM node:latest
WORKDIR /app
RUN npm install 2 > /dev/null
RUN npm install -g bower 2 > /dev/null
RUN npm rebuild node-sass
RUN node node_modules/gulp/bin/gulp.js --production &> /dev/null
RUN bower install &> /dev/null
