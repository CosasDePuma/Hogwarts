FROM node:alpine
COPY . /web
WORKDIR /web
RUN npm i -g npm@7.0.13; npm i
EXPOSE 3000
ENTRYPOINT ["npm", "start"]