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

export default class Api {

    constructor(args) {
        this.action = args?.additionnal?.[0];

        this.additionnal = args?.additionnal.splice(1);
        this.cliEnv = args?.cliEnv;
    }

    actions() {
        return {
            logs: () => this.logs(),
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

        logs          displays npm logs

        `
        Console.log(usageText);
    }

    async run(){
        if(!Object.keys(this.actions()).includes(this.action)){
            this.usage();
            this.action = await selectAction(Object.keys(this.actions()));
        }

        cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
        this.actions()[this.action](this.additionnal);
    }

    async logs() {
        try{
            await $`docker compose logs -f -t 100 --no-log-prefix front-app`;
        }catch(e){
            Console.printError(e);
        }
        Console.confirm('up done');
    }
}
