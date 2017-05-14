FROM node:latest
WORKDIR /app
RUN npm install
RUN npm install -g gulp
RUN npm install -g bower
RUN gulp --production
