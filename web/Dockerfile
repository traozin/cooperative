FROM node:20

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .

EXPOSE 3001

COPY entrypoint.sh /entrypoint.sh
RUN apt-get update && apt-get install -y dos2unix && \
    dos2unix /entrypoint.sh && chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]