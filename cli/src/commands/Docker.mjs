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

const actions = [
    'build',
    'convert',
    'cp',
    'create',
    'down',
    'events',
    'exec',
    'images',
    'kill',
    'logs',
    'ls',
    'pause',
    'port',
    'ps',
    'pull',
    'push',
    'restart',
    'rm',
    'run',
    'start',
    'stop',
    'top',
    'unpause',
    'up',
    'version'
];

export default class Docker {

    constructor(args){
        this.action = args?.additionnal?.[0];

        this.additionnal = args?.additionnal.splice(1);
        this.cliEnv = args?.cliEnv;
    }

    usage() {
        const usageText = `
        Constellation CLI utils.

        Usage: constellation-cli docker [OPTIONS] COMMAND

        Options:

            -h, --help      Print this help and exit
            -v, --verbose   Print script debug info

        Management Commands:

            build       Build or rebuild services
            convert     Converts the compose file to platform's canonical format
            cp          Copy files/folders between a service container and the local filesystem
            create      Creates containers for a service.
            down        Stop and remove containers, networks
            events      Receive real time events from containers.
            exec        Execute a command in a running container.
            images      List images used by the created containers
            kill        Force stop service containers.
            logs        View output from containers
            ls          List running compose projects
            pause       Pause services
            port        Print the public port for a port binding.
            ps          List containers
            pull        Pull service images
            push        Push service images
            restart     Restart service containers
            rm          Removes stopped service containers
            run         Run a one-off command on a service.
            start       Start services
            stop        Stop services
            top         Display the running processes
            unpause     Unpause services
            up          Create and start containers
            version     Show the Docker Compose version information

        `
        Console.log(usageText);
    }

    async run(){
        if(!actions.includes(this.action)){
            this.usage();
            this.action = await selectAction(actions);
        }

        cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
        $`docker compose ${this.action} ${this.additionnal}`
            .pipe(process.stdout)
            .catch((p) => {
                Console.printError(p);
            });
    }
}

