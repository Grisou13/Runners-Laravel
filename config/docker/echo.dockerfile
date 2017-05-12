FROM node:7.10.10

RUN npm install laravel-echo-server -g

WORKDIR /app

EXPOSE 6001

CMD ["laravel-echo-server", "start"]