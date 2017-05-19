FROM node:latest
WORKDIR /app
RUN npm install -g yarn 2 > /dev/null
RUN npm install -g bower 2 > /dev/null

RUN bower install &> /dev/null
RUN yarn 2 > /dev/null

RUN npm rebuild node-sass 2 > /dev/null
RUN node node_modules/gulp/bin/gulp.js --production &> /dev/null
