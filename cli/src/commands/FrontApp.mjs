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
        };
    }

    usage() {
        const usageText = `
        Constellation CLI utils.

        Usage: constellation-cli front-app [OPTIONS] COMMAND

        Options:

            -h, --help      Print this help and exit
            -v, --verbose   Print script debug info

        Management Commands:

        logs          displays npm logs

        `
        Console.log(usageText);
    }

    async logs() {
        try{
            await $`docker compose logs -f -n 300 --no-log-prefix front-app`;
        }catch(e){
            Console.printError(e);
        }
        Console.confirm('up done');
    }
}
