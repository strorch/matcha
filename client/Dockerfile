FROM node:10.15.3-alpine

# set working directory
WORKDIR /app

COPY package.json /app/package.json
RUN yarn install

# start app
CMD ["yarn", "start"]

# docker build . -t matcha-client
