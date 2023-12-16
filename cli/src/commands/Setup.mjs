#!/usr/bin/env zx

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

import { spinner } from 'zx/experimental';
import { $, cd } from 'zx/core';
import { fs } from 'zx';
import * as dotenv from 'dotenv';
import generator from 'generate-password';

import Console from '../utils/Console.mjs';
import Environment, { isProd } from '../utils/Environment.mjs';
import AbstractCommand from './AbstractCommand.mjs';

export default class Setup extends AbstractCommand {

  actions() {
    return {
      install: () => this.install(),
      up: () => this.up(),
      down: () => this.down(),
      restart: () => this.restart(),
    };
  }

  usage() {
    const usageText = `
        Constellation CLI utils.

        Usage: constellation-cli setup [OPTIONS] COMMAND

        Options:

            -h, --help      Print this help and exit
            -v, --verbose   Print script debug info

        Management Commands:

        install     Initialize instance
            Options

            --force-reinstall   Force reconfigure env files and database (will drop previous setup).

        up          Alias for docker compose up -d
            Options

            --fresh             Fresh database after mounting.
            --seed              Php artisan db:seed
            --logs              Display web ui logs at the end of the setup.

        down        Alias for docker compose down
        restart     Alias for docker compose restart

        `
    Console.log(usageText);
  }

  getAdditionalArgsByCommand() {
    return {
      'install': [
        {
          title: 'force-reinstall',
          value: '--force-reinstall',
          description: 'Warning: Don\'t forget to backup them before continue.'
        }
      ],
      'up': [
        { title: 'fresh', value: '--fresh', description: 'Warning: This will drop your current data !' },
        { title: 'seed', value: '--seed' },
        { title: 'logs', value: '--logs' },
      ]
    }
  }

  async install() {
    try {
      const installDir = path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV);
      cd(installDir);
      const dockerComposeEnvFile = path.join(installDir, '.env');
      let dockerComposeConfig;
      if (fs.existsSync(dockerComposeEnvFile)) {
        if (this.additional.includes('--force-reinstall')) {
          Console.info(`${dockerComposeEnvFile} already exists. Skip init.`);
          dockerComposeConfig = dotenv.parse(fs.readFileSync(dockerComposeEnvFile));
        } else {
          Console.error(`${dockerComposeEnvFile} already exists. Install aborted. To force reinstall use --force-reinstall option.`);
          process.exit(1);
        }
      } else {
        dockerComposeConfig = dotenv.parse(fs.readFileSync(`${dockerComposeEnvFile}.example`));

        const onCancel = () => {
          Console.info('Canceled');
          process.exit(0);
        }

        const response = await Console.prompts([
          {
            name: 'TAG_NAME',
            type: 'text',
            message: 'Please define the version you want to deploy (ignored if Development mode)',
            initial: 'latest'
          },
          {
            name: 'DATA_VOLUME',
            type: 'text',
            message: 'Please define the directory where the data is stored on the host',
            initial: `${os.homedir()}/.constellation`,
          },
          {
            name: 'MARIADB_DATABASE',
            type: 'text',
            message: 'Please define the Mariadb database name',
            initial: dockerComposeConfig?.MARIADB_DATABASE,
          },
          {
            name: 'MARIADB_ROOT_PASSWORD',
            type: 'password',
            message: 'Please define the root Mariadb password (press enter to use auto-generated password)',
            initial: generator.generate({
              length: 15,
              numbers: true,
            })
          },
          {
            name: 'MARIADB_USER',
            type: 'text',
            message: 'Please define the Mariadb database username',
            initial: dockerComposeConfig?.MARIADB_USER,
          },
          {
            name: 'MARIADB_PASSWORD',
            type: 'password',
            message: 'Please define the Constellation Mariadb user password (press enter to use auto-generated password)',
            initial: generator.generate({
              length: 15,
              numbers: true,
            })
          },
          {
            name: 'MEILI_MASTER_KEY',
            type: 'password',
            message: 'Please define the Meilisearch master key (press enter to use auto-generated password)',
            initial: generator.generate({
              length: 15,
              numbers: true,
            })
          }, {
            name: 'SCHEMA',
            type: 'select',
            message: 'Please define the uri schema',
            choices: [
              { title: 'http', value: 'http' },
              { title: 'https', value: 'https' },
            ],
            initial: 0,
          },
          {
            name: 'WEBUI_HOSTNAME',
            type: 'text',
            message: 'Please define the web ui domain',
            initial: 'localhost'
          },
          {
            name: 'WEBUI_PORT',
            type: 'number',
            message: 'Please define the web ui port',
            initial: 443
          },
          {
            name: 'API_HOSTNAME',
            type: 'text',
            message: 'Please define the api domain',
            initial: 'localhost'
          },
          {
            name: 'API_PORT',
            type: 'number',
            message: 'Please define the api port',
            initial: 443
          }
        ], { onCancel });

        dockerComposeConfig.API_SOURCE_VOLUME = path.join(this.cliEnv?.rootDir, 'api');
        dockerComposeConfig.FRONT_SOURCE_VOLUME = path.join(this.cliEnv?.rootDir, 'web-ui');

        dockerComposeConfig = {
          ...dockerComposeConfig,
          ...response
        };

        if (dockerComposeConfig.API_PORT === dockerComposeConfig.WEBUI_PORT && dockerComposeConfig.API_HOSTNAME === dockerComposeConfig.WEBUI_HOSTNAME) {
          Console.error("Web UI and API cannot have the same domain+port. For localhost setup, choose a different port.");
          process.exit(1);
        }

        if (fs.existsSync(dockerComposeConfig.DATA_VOLUME)) {
          Console.warn(`${dockerComposeConfig.DATA_VOLUME} already exists.`);
          const confirmErase = await Console.prompts({
            type: 'confirm',
            name: 'continue',
            message: 'Data volume is already existing. Are you sure to continue ?',
            initial: false
          });

          if (confirmErase.continue === false) {
            Console.info('Exit');
            process.exit(0);
          }
        }

        for (const configKey in dockerComposeConfig) {
          await $`echo -e '${configKey}=${dockerComposeConfig[configKey]}' >> ${dockerComposeEnvFile}`;
        }
        Console.confirm("Docker compose .env file generated",
          `WebUI: ${dockerComposeConfig.SCHEMA}://${dockerComposeConfig.WEBUI_HOSTNAME}:${dockerComposeConfig.WEBUI_PORT}`,
          `API: ${dockerComposeConfig.SCHEMA}://${dockerComposeConfig.API_HOSTNAME}:${dockerComposeConfig.API_PORT}`
        );
      }

      Console.info("Start stack");
      await $`touch web-ui/env.js`;
      await $`docker compose pull`;
      await spinner('docker compose up --remove-orphans -d',
        async () => {
          $.verbose = true;
          await $`docker compose up --remove-orphans -d`;
        }
      );

      await spinner('wait for mariadb is up.',
        async () => {
          $.verbose = false;
          await retry(10, '2s', () => $`docker compose exec mariadb mariadb-admin ping -hlocalhost -uroot -p${dockerComposeConfig?.MARIADB_ROOT_PASSWORD}`);
        }
      );
      if (!isProd()) {
        await retry(3, '2s', () => $`docker compose exec mariadb mariadb --user=root --password="${dockerComposeConfig?.MARIADB_ROOT_PASSWORD}" "${dockerComposeConfig?.MARIADB_DATABASE}" -e "CREATE DATABASE IF NOT EXISTS Constellation_test"`);
      }

      await $`docker compose exec api cp .env.example .env`;
      if (!isProd()) {
        await $`docker compose exec api composer install`;
      }
      await $`docker compose exec api php artisan key:generate`;

      Console.info("Prepare API");
      await $`docker compose restart`;
      await spinner('wait for mariadb is up.',
        async () => {
          $.verbose = false;
          await retry(10, '1s', () => $`docker compose exec mariadb mariadb-admin ping -hlocalhost -uroot -p${dockerComposeConfig?.MARIADB_ROOT_PASSWORD}`);
        }
      );

      await $`docker compose exec -it api php artisan migrate:fresh --force`;
      await $`docker compose exec -it api php artisan db:seed --force`;
      await $`docker compose exec -it api php artisan app:refresh-all-indexes`;

      Console.info("Generate Oauth2 keys");
      await $`docker compose exec api php artisan passport:keys --force`;
      await $`docker compose exec api chmod 644 storage/oauth-private.key`;
      await $`docker compose exec api chmod 644 storage/oauth-public.key`;
      await $`docker compose exec api chown www-data storage/oauth-private.key`;
      await $`docker compose exec api chown www-data storage/oauth-public.key`;
      await $`docker compose exec api chgrp -R www-data storage/`;

      const clientKeys = await $`docker compose exec api php artisan passport:client --password`;
      const clientIdResult = new RegExp(/Client ID: (.*)/g).exec(clientKeys);
      const clientSecretResult = new RegExp(/Client secret: (.*)/g).exec(clientKeys);

      const webUIEnvVars = JSON.stringify({
        APP_ISSUER: `${dockerComposeConfig.SCHEMA}://${dockerComposeConfig.API_HOSTNAME}:${dockerComposeConfig.API_PORT}`,
        APP_API_URL: `${dockerComposeConfig.SCHEMA}://${dockerComposeConfig.API_HOSTNAME}:${dockerComposeConfig.API_PORT}/api`,
        CORS_ALLOWED_ORIGINS: `${dockerComposeConfig.SCHEMA}://${dockerComposeConfig.WEBUI_HOSTNAME}`,
        APP_CLIENT_ID: `${clientIdResult[1]}`,
        APP_CLIENT_SECRET: `${clientSecretResult[1]}`,
      });

      const envJs = `window.env = ${webUIEnvVars};`;
      fs.writeFileSync('web-ui/env.js', envJs);

      await $`docker compose up --force-recreate -d web-ui `;

      await $`docker compose exec api php artisan config:clear`;
      if (isProd()) {
        await $`docker compose exec api php artisan config:cache`;
      }

      const confirmRunSeeder = await Console.prompts({
        type: 'confirm',
        name: 'run_application_example_seeder',
        message: 'Would like to run the example application seeder ?',
        initial: false
      });

      if (confirmRunSeeder.run_application_example_seeder === true) {
        await $`docker compose exec api php artisan db:seed --force --class=AppExampleSeeder`;
      }

    } catch (e) {
      Console.error("Error during install", e);
      process.exit(1);
    }
    Console.confirm('Install completed');
  }

  async up() {
    cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
    try {
      await spinner('docker compose up  -d',
        async () => await $`docker compose up  -d`
      );

      await spinner('api composer install',
        async () => {
          $.verbose = true;
          return await $`docker compose exec -it api composer install`
        }
      );

      if (!isProd()) {
        await spinner('web ui npm install',
          async () => {
            $.verbose = true;
            await $`docker compose exec -it web-ui npm i`
          }
        );
      }

      if (this.additional.includes('--fresh')) {
        await spinner('php artisan migrate:fresh',
          async () => {
            $.verbose = true;
            await $`docker compose exec -it api php artisan migrate:fresh`
          }
        );
      }

      if (this.additional.includes('--seed')) {
        await spinner('php artisan db:seed',
          async () => {
            $.verbose = true;
            await $`docker compose exec -it api php artisan db:seed`
          }
        );
      }

      if (this.additional.includes('--logs')) {
        await $`docker compose logs -f -t 100 --no-log-prefix *`
      }

    } catch (e) {
      Console.error("Error during up", e);
      process.exit(1);
    }
    Console.confirm('up done');
  }

  async down() {
    cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
    try {
      await spinner('docker compose down',
        async () => await $`docker compose down`
      );
    } catch (e) {
      Console.printError(e);
      process.exit(1);
    }
    Console.confirm('down done');
  }

  async restart() {
    cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
    try {
      await $`docker compose restart`;
    } catch (e) {
      Console.printError(e);
      process.exit(1);
    }
    Console.confirm('restart done');
  }
}
