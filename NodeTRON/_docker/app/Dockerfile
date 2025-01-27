FROM node:18

WORKDIR /var/www/NodeTRON

COPY ./NodeTRON/package*.json ./ 

RUN npm install

COPY ./NodeTRON ./

RUN chmod -R 755 /var/www/NodeTRON

EXPOSE 3000

CMD ["npm", "start"]
