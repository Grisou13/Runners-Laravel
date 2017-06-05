FROM node:latest
WORKDIR /app
#COPY config/broadcasting/laravel-echo-server-staging.json /app/laravel-echo-server.json
RUN apt-get install gcc
RUN apt-get install g++
RUN npm install laravel-echo-server -g


EXPOSE 6001

CMD ["laravel-echo-server", "start"]
