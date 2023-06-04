FROM node:18

LABEL maintainer="Alexandre BORDIN <bordin.alexandre@gmail.com>"

# Get user arg
ARG MYUSER=${MYUSER}

# Add user
RUN useradd -ms /bin/bash -G www-data ${MYUSER} || echo "User already exists."

# Expose port
EXPOSE 3000

# Define workdir
WORKDIR /var/www

CMD npm install && npm run start
