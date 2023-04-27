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
import AbstractCommand from './AbstractCommand.mjs';

export default class Api extends AbstractCommand {

    actions() {
        return {
            logs: () => this.logs(),
            test: () => this.test(),
        };
    }

    usage() {
        const usageText = `
        Constellation CLI utils.

        Usage: constellation-cli api [OPTIONS] COMMAND

        Options:

            -h, --help      Print this help and exit
            -v, --verbose   Print script debug info

        Management Commands:

        logs          displays api logs (Laravel only by default)
            Options

            --nginx   Display Nginx logs

        test          executes phpunit tests

        `
        Console.log(usageText);
    }

    async logs() {
        try{

            if(this.additionnal.includes('--nginx')){
                await $`docker compose logs -f -n 100 --no-log-prefix nginx`;
            }else{
                await $`docker compose logs -f -n 100 --no-log-prefix api`;
            }

        }catch(e){
            Console.printError(e);
        }
        Console.confirm('up done');
    }

    async test() {
        try{
            cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
            await $`docker compose exec -it api ./vendor/bin/phpunit`;
        }catch(e){
            Console.printError(e);
        }
    }
}
