FROM node:latest
WORKDIR /app
RUN curl -o- -L https://yarnpkg.com/install.sh | bash
RUN npm install -g bower &> /dev/null
copy node.sh /opt/bin/entrypoint.sh
RUN chmod +x /opt/bin/entrypoint.sh
CMD ["/opt/bin/entrypoint.sh"]
