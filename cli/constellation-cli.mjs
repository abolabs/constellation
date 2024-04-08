#!/usr/bin/npx zx

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


import Artisan from './src/commands/Artisan.mjs';
import * as Base from './src/commands/Base.mjs';
import Console from './src/utils/Console.mjs';
import Docker from './src/commands/Docker.mjs';
import * as Environment from './src/utils/Environment.mjs';
import Setup from './src/commands/Setup.mjs';
import Api from './src/commands/Api.mjs';
import WebUI from './src/commands/WebUI.mjs';
import CI from './src/commands/CI.mjs';
import * as dotenv from 'dotenv';
import { $ } from 'zx/core';
import path from 'path';

dotenv.config({ path: path.join(__dirname, '/.env') });

if ($.verbose) {
  Base.printTitle()
}

await Environment.initEnv();

const args = Base.getArgs();

let mainCommand = args?.main;
if (!mainCommand) {
  mainCommand = await Base.selectAction([
    'setup',
    'api',
    'web-ui',
    'docker',
    'artisan',
    'ci'
  ]);
}

let commandObj;

switch (mainCommand) {
  // Services
  case 'setup':
    commandObj = Setup;
    break;
  case 'api':
    commandObj = Api;
    break;
  case 'web-ui':
    commandObj = WebUI;
    break;
  // Wrappers
  case 'docker':
    commandObj = Docker;
    break;
  case 'artisan':
    commandObj = Artisan;
    break;
  // CI
  case 'ci':
    commandObj = CI;
    break;
  default:
    usage();
    process.exit(0);
}

new (commandObj)(args).run();

function usage() {
  const usageText = `
    Constellation CLI utils.

    Usage: constellation-cli [OPTIONS] COMMAND

    Options:

        -h, --help      Print this help and exit.
        -v, --verbose   Print script debug info.
        -f, --flag      Some flag description.
        -p, --param     Some param description.

    Services commands:
        setup           Shorcuts to mount/unmout/update the environment.
        api             Globals utils for the API service.
        web-ui          Front App commands.

    Wrappers commands:
        docker          Wrapper for ./install/{env}/docker-compose.yml files.
        artisan         Run artisan command on the API service.

    CI commands:
        ci              Commands for CI environment.

    `
  Console.log(usageText);
}
