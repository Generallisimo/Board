FROM node:18

WORKDIR /var/www/NodeTRON

# Копируем package.json и package-lock.json перед установкой зависимостей
COPY ./NodeTRON/package*.json ./

# Устанавливаем зависимости
RUN npm install

# Устанавливаем nodemon глобально
RUN npm install -g nodemon

# Копируем весь код после установки зависимостей (чтобы не перезаписывать node_modules)
COPY ./NodeTRON ./

# Даем нужные права
RUN chmod -R 755 /var/www/NodeTRON

EXPOSE 3000

CMD ["npm", "start"]
