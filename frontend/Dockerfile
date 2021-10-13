FROM node:12.18.1

WORKDIR /app/frontend

COPY . .

RUN curl -sL https://deb.nodesource.com/setup_16.x  | bash -
RUN npm install

EXPOSE 3000

CMD npm start