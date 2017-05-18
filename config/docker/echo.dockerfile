FROM node:latest
ADD config/broadcasting/laravel-echo-server-staging.json /app/laravel-echo-server.json
RUN apt-get install gcc
RUN apt-get install g++
RUN npm install laravel-echo-server -g
WORKDIR /app

EXPOSE 6001

CMD ["laravel-echo-server", "start"]
