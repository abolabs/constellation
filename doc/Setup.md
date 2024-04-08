# Setup

The instructions below show how to setup the application with Docker and the Constellation CLI tool.

## 1. Initialize CLI tool

```sh
cd ./cli
chmod 755 constellation-cli.mjs
```

(Optional) To use the CLI tool from anywhere you can add a command alias in your `.bashrc` file:

```sh
alias constellation-cli="/path/to/constellation/cli/constellation-cli.mjs"
```

## 2. Step by step install

### Launch the CLI tool

```sh
# if using the command alias
$ constellation-cli 
# else
$ ./constellation-cli.mjs 
```

### Select your environment

```sh
? No environment provided. Please choose one. › - Use arrow-keys. Return to submit.
    Development
❯   Production
```

  - `Development` will use the local Dockerfile to build the stack.
  - `Production` will use the latest stable released Docker images.

### Select install command

Choose 'setup'

```sh
? No action provided. Please choose one. › - Use arrow-keys. Return to submit.
❯   setup
    api
    web-ui
    docker
    artisan
    ci
```

Then 'install'

```sh
? No action provided. Please choose one. › - Use arrow-keys. Return to submit.
❯   install
    up
    down
    restart
```

> :warning: If you have already made a first install, remove volume shared directory, then select the option 'force-reinstall' on the next prompt, just press enter/return in the other case.

### Configuration form

Below are the questions on the form and instructions for completing it.

```sh
? Please define the version you want to deploy › latest
```

- Keep `latest` to choose the latest stable release. Go to https://gitlab.com/abolabs/constellation/container_registry to select another release.

```sh
? Please define the directory where the data is stored on the host › /home/username/.constellation
```

- Select the path where persistent data will be stored.

```sh
? Please define the Mariadb database name › Constellation
```

- Select the database name (see [official documentation](https://mariadb.com/kb/en/identifier-names/) to know the rules in database naming).

```sh
? Please define the root Mariadb password (press enter to use auto-generated password) › ***************
```

- Set the Mariadb root password. By default a new password is automatically generated. You can retrieve it later, in the `constellation/install/prod/.env` file.

```sh
? Please define the Mariadb database username › constellation_db_user
```

- Customize the database username, or press enter/return to keep the default value.

```sh
? Please define the Constellation Mariadb user password (press enter to use auto-generated password) › ***************
```

- Define the Mariadb user password. By default a new password is automatically generated. You will be able to retrieve it later, in the `constellation/install/prod/.env` file.

```sh
? Please define the Meilisearch master key (press enter to use auto-generated password) › ***************
```

- Define the Meilisearch master key. By default a new key is automatically generated. You will be able to retrieve it later, in the `constellation/install/prod/.env` file.

```sh
? Please define the uri schema › - Use arrow-keys. Return to submit.
❯  http
   https
```

- For production, please choose `https`. The SSL certificate will be automatically generated with [Let's encrypt](https://letsencrypt.org/).

```sh
? Please define the web ui domain › localhost
```

- Choose the domain name where the web ui will be exposed.

```sh
? Please define the api domain › localhost
```

- Choose the domain name where the api will be exposed.

### Finalization

After fill the api domain name, the CLI tool will initialize the stack. Only 2 last questions will be asked:

```sh
What should we name the password grant client? [Constellation Password Grant Client]:
>
Which user provider should this client use to retrieve users? [users]:
[0] users
>
```

You can keep the default value or customize the password grant client name. (see [official documentation](https://laravel.com/docs/10.x/passport#creating-a-password-grant-client)).

```sh
? Would like to run the example application seeder ? › (y/N)
```

Press `y` if you want to init the data with an example of stack in Constellation.

The application should now be ready to use.

Default admin account is defined in  [`CreateAdminUserSeeder.php`](../api/database/seeders/CreateAdminUserSeeder.php), you should update it from  as soon as possible. 

<p align="right" dir="">(<a href="#top">back to top</a>)</p>

## FAQ


### Can I use https locally ? 

Yes, in production mode, Traefik will automatically generate self-signed certificate, but you will have to manually accept the certificate. 

e.g, if you choose `API_HOSTNAME=localhost`, `API_PORT=8080`, go to https://localhost:8080/api with your browser and choose "Proceed to localhost"

### Can I use domain name locally ? 

Yes, you can easily defined a custom domain with editing your `/etc/hosts` file.

e.g: `127.0.0.1       constellation.local     api.constellation.local`
