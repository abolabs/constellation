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


import Console from '../utils/Console.mjs';
import * as path from 'path';
import {selectAction} from './Base.mjs';
import { spinner } from 'zx/experimental';
import Environment from '../utils/Environment.mjs';
import AbstractCommand from './AbstractCommand.mjs';

export default class Setup extends AbstractCommand {

    actions() {
        return {
            up: () => this.up(),
            down: () => this.down(),
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

        up          Alias for docker compose up -d
            Options

            --fresh         Fresh database after mounting.

        down        Alias for docker compose down


        `
        Console.log(usageText);
    }

    async up() {
        try{
            await spinner('docker compose up  -d',
                async () => await $`docker compose up  -d`
            );

            await spinner('api composer install',
                async () => await $`docker compose exec -it api composer install`
            );

            await spinner('front app npm install',
                async () => await $`docker compose exec -it front-app npm i`
            );

            if(this.additionnal.includes('--fresh')){
                await spinner('php artisan migrate:fresh',
                    async () => await $`docker compose exec -it api php artisan migrate:fresh`
                );
            }

            if(this.additionnal.includes('--seed')){
                await spinner('php artisan db:seed',
                    async () => await $`docker compose exec -it api php artisan db:seed`
                );
            }

            if(this.additionnal.includes('--logs')){
                if(process.env.APP_ENV !== Environment.DEV_ENV) {
                    Console.error("Watch is only available on dev environment");
                    process.exit(1);
                }
                await $`docker compose restart front-app`
                await $`docker compose logs -f -t 100 front-app`
            }

        }catch(e){
            Console.printError(e);
        }
        Console.confirm('up done');
    }

    async down() {
        try{
            await spinner('docker compose down',
                async () => await $`docker compose down`
            );
        }catch(e){
            Console.printError(e);
        }
        Console.confirm('down done');
    }
}
