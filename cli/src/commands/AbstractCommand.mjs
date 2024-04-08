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

import * as path from 'path';
import { selectAction } from './Base.mjs';
import Console from '../utils/Console.mjs';

export default class AbstractCommand {

  constructor(args) {
    this.action = args?.additional?.[0];

    this.additional = args?.additional.splice(1);
    this.cliEnv = args?.cliEnv;
  }

  getAdditionalArgsByCommand() {
    return {};
  }

  async getAdditionalArgs(multiple = true) {
    if (this.getAdditionalArgs.length > 0) {
      // option(s) provided inline, ignore asking for options
      return;
    }
    const availableOptions = this.getAdditionalArgsByCommand()?.[this.action];
    if (availableOptions?.length === 0 || !availableOptions) {
      return [];
    }
    const onCancel = prompt => {
      Console.warn("Command cancelled. Exit.");
      process.exit(0);
    }
    const response = await Console.prompts({
      type: multiple ? 'multiselect' : 'autocomplete',
      name: 'options',
      message: 'Select options',
      choices: availableOptions,
    }, { onCancel });
    if (multiple) {
      this.additional = response.options;
    } else {
      this.additional = [response.options];
    }

  }

  async run() {
    if (!Object.keys(this.actions()).includes(this.action)) {
      this.usage();
      this.action = await selectAction(Object.keys(this.actions()));
    }
    cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
    if (this.action) {
      await this.getAdditionalArgs();
      this.actions()[this.action](this.additional);
    }
  }

}
