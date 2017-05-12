FROM node:latest

RUN npm install laravel-echo-server -g

WORKDIR /app

EXPOSE 6001

CMD ["laravel-echo-server", "start"]
