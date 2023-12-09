#### 1. Initialize the docker compose environment file

```sh
cp ./install/dev/.env.example .env
```

#### 2. Edit the Docker stack environment file

- `MYUSER` Username in the api container.
- `COMPOSE_PROJECT_NAME` Name of the stack in Docker.
- `DATA_VOLUME` Sharing directory for storing service data (Mariadb, Nginx, Redis).
- `SOURCE_VOLUME` Location of application sources (ex.: `/home/myname/project/Constellation`).
- Mariadb - The information below must match that of the `.env` Laravel file, at the root of the project).
  - `MARIADB_USER` Mariadb username.
  - `MARIADB_PWD` Mot de passe.
  - `MARIADB_PORT` Port Mariadb shared with the Docker host.
  - `MARIADB_DATABASE` Database name initialized by default.
- **MailDev** - Debug service used to catch emails in local environment.
  _(see https://hub.docker.com/r/maildev/maildev)_
  _ `SMTP` Port shared with the host for listening to messages to be captured.
  _ `WEBUI` Port shared with the host to access the email display interface.

#### 3. Build the stack

```sh
docker-compose up -d
```

All services should go up, allowing you to move on to the initializing of the application.
If not, check the information entered in the `./install/dev/.env` file.
If the ports are already in used by other services, change the configuration.

#### 4. Application initialization

- Enter the api container on CLI.
  ```sh
  docker exec -it constellation_api_1 bash
  ```
- Switch to app user
  ```sh
  su app_user
  ```
  _(`app_user` corresponds here to what has been defined in the variable `MYUSER`)_
- Initialize the Laravel environment file
  ```sh
  cp .env.example .env
  ```
- Edit the file to match what has been defined in the file `./install/dev/.env`.
  You can also modify the other variables according to your environment (see https://laravel.com/docs/9.x/configuration).
- Install & compile libraries
  - PHP
  ```sh
  composer install
  ```
- Initialize the database

  - Edit the administrator.
    Edit file `./database/seeders/CreateAdminUserSeeder.php`.
    Edit the name, email and password at your convenience

  ```php
  'name' => 'Super Admin',
  'email' => 'admin@localhost',
  'password' => bcrypt('super_secured_password')
  ```

  - Initialization of tables

  ```sh
  php artisan migrate --seed
  ```

  - (Optional) Load example applications

  ```sh
  php artisan db:seed --class=AppExampleSeeder

  ```

#### 6. Passport

Generate the OAuth2 keys and client.

- Always inside the api container, setup the Passport keys with `php artisan passport:install`.

- Generate a client with passport grant with `php artisan passport:client --password`.

  _Example :_

  ```sh
    app_user@2aff63ab4afa:/var/www$ php artisan passport:client --password

    What should we name the password grant client? [Constellation Password Grant Client]:
    >

    Which user provider should this client use to retrieve users? [users]:
    [0] users
    > 0

    Password grant client created successfully.
    Client ID: 9749af7c-bd7b-4a8f-af93-da0735447434
    Client secret: 62xSrCWaW6VfIdszfVYoXyKFVzOjYHHZplVQWO84
  ```

  Keep client information in a safe place.

- Configure the web ui

  - Open a new bash on the web-ui container
    `docker exec -it constellation-web-ui-1 bash`

  - Switch to app_user

    ```sh
    su app_user
    ```

  - Init the environment file
    `cp .env.example .env`

  - Configure the environment file
    Edit the client information
    ```sh
    REACT_APP_CLIENT_ID="9749af7c-bd7b-4a8f-af93-da0735447434"
    REACT_APP_CLIENT_SECRET="62xSrCWaW6VfIdszfVYoXyKFVzOjYHHZplVQWO84"
    ```

#### 7. Front App configuration

Always on the web-ui container and as app_user.

- Install npm librairies

  ```sh
  npm install && npm run production
  ```

- You can now simply start the service
  ```sh
  npm run start
  ```

#### 8. Finalization

Well done, you have just finished installing the solution.
You can now log in the interface.
With the default configuration, the application will be accessible locally from the following url: http://localhost:3000 (the api on http://localhost:8080)
