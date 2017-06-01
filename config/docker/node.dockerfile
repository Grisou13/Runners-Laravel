FROM node:latest
WORKDIR /app
RUN curl -o- -L https://yarnpkg.com/install.sh | bash

RUN npm install -g bower &> /dev/null

RUN bower install &> /dev/null
RUN $HOME/.yarn/bin/yarn install

RUN npm rebuild node-sass 2 > /dev/null
RUN node node_modules/gulp/bin/gulp.js --production &> /dev/null
