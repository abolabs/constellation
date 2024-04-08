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


import gradient from 'gradient-string';
import * as path from 'path';
import Console from '../utils/Console.mjs';
import Ajv from 'ajv';

export function printTitle() {
  const title = gradient(['#084C61', '#177E89', '#084C61']).multiline(`


            ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
            ░░░░░░░░░░░░░░░░▒▒▒▒░░░░░░░░░░░░░░░░░░░░
            ░░░░░░░░░░░░░░░▒░▒░░▒▒░░░░░░░░░░░░░░░░░░
            ░░░░░░░░░░░░░░▒░▒▒░░░░▒▒░░▒▒▒▒▒▒▒░░░░░░░
            ░░░░░▒▒▒▒▒▒▒▒▒▒▒▓▒▒▒▒▒▒▒▒▒▒▒▒░░░▒░░░░░░░
            ░░░░░▒▒░░░░░▒▓▒▓▒▒▒▒▒▒▒▒▓▒▒▒▒▒░░▒░░░░░░░
            ░░░░░▒░▒░▒▓▒▒▒▒▓▓▓▒▒▓▓▓▓▓▓▒░▒▒░░▒░░░░░░░
            ░░░░░░▒░▓▒▒▒▓▒▓▓▓▓▓▓▒▒▓▓▒▒▓▓▒▓▒▒▒░░░░░░░
            ░░░░░░▒▓▒▒▓▓▓▒▒▓▓▒▒▒▒▒▓▒▓▓▓▒▓▓▓▒▒░░▒▒░░░
            ░░░░▒▒░░▓▒▒▒▒▓▒▒░░░░░░░▒▒▒▓▒▒▓▒▒▒░▒▒▒▓▒░
            ░░▒▒░░░▒▒▒▒▓▓▒▓░░░░░░░░░▓▒▓▓▒▓▒▒▓░░░▒▒░░
            ░▒▒▒░░▒▒▒▒▓▒▓▒▓▒░░░░░░░▒▒▓▓▒▓▓▒▓▓░▒▒░░░░
            ░░▒▒▒▒▒▒▓▒▒▓▓▒▓▓▒░░░░▒▒▓▒▓▓▓▓▓▒▒▓▒░░░░░░
            ░░░░░░▒▒▓▒▒▒▒▓▓▒▒▓▓▓▒▒▒▓▒▓▒▓▓▒▒▒░▒░░░░░░
            ░░░░░░░░▒░▒▓▒▓▓▓▓▓▒▓▓▒▓▓▓▒▒▒▒▓░▒▒░▒░░░░░
            ░░░░░░░░▓░░▒▒▒▒▒▒▒▒▓▒▓▒▒▓▒▓▒░░░░▒▒▒░░░░░
            ░░░░░░░░▓░░▒▒▒▒▓▒▒▒▒▒▒▒▒▒▓▒▒▒▒▒▒▒▒░░░░░░
            ░░░░░░░░▒▒▒▒▒▒░░▒▒░░░░▒▒░▒░░░░░░░░░░░░░░
            ░░░░░░░░░░░░░░░░░░░▒░░▒░▒░░░░░░░░░░░░░░░
            ░░░░░░░░░░░░░░░░░░░░░▒▒░░░░░░░░░░░░░░░░░
            ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░


     __   __        __  ___  ___                ___    __
    /  \` /  \\ |\\ | /__\`  |  |__  |    |     /\\   |  | /  \\ |\\ |
    \\__, \\__/ | \\| .__/  |  |___ |___ |___ /~~\\  |  | \\__/ | \\|
                _________________________________
    `);
  Console.log(title);
}

export function getArgs() {
  const args = process.argv.slice(3);

  return {
    main: args?.[0],
    additional: args.slice(1),
    cliEnv: {
      rootDir: getRootDir()
    }
  }
}

export function getRootDir() {
  return path.resolve(__dirname, '..');
}

export async function selectAction(actions) {

  const response = await Console.prompts([
    {
      type: 'select',
      name: 'action',
      message: 'No action provided. Please choose one.',
      choices: actions,
      initial: 0
    }
  ]);
  const action = actions?.[response.action];


  const schema = {
    type: 'object',
    properties: {
      action: {
        type: 'string',
        enum: actions
      }
    }
  };

  const ajv = new Ajv()
  const validate = ajv.compile(schema);
  const valid = validate({ action: action });

  if (!valid) {
    Console.error(validate.errors, action);
    process.exit(1);
  }
  return action;
}
