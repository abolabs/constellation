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


import Ajv from 'ajv';
import Console from './Console.mjs';

export const DEV_ENV = 'dev';
export const PROD_ENV = 'prod';

const envSchemaValidation = {
    type: 'object',
    properties: {
        env:{
            type: 'string',
            enum: ['dev','prod']
        }
    },
    required: ["env"]
};

export async function initEnv() {

    const ajv = new Ajv()
    const validate = ajv.compile(envSchemaValidation);
    const valid = validate({env: process.env.APP_ENV});

    if(!valid){
        await selectEnv();
    }
    Console.info(`Environment : ${process.env.APP_ENV}`);
}

async function selectEnv() {

    const response = await Console.prompts([
        {
            type: 'select',
            name: 'env',
            message: 'No environment provided. Please choose one.',
            choices: [
                { title: 'Development', description: 'Only for local development purposes.', value: 'dev' },
                { title: 'Production', value: 'prod' }
            ],
            initial: 0
        }
    ]);

    const ajv = new Ajv()
    const validate = ajv.compile(envSchemaValidation);
    const valid = validate({env: response.env});

    if(!valid){
        Console.error('Cannot initialise environment', validate.errors, response.env);
        process.exit(1);
    }
    process.env.APP_ENV = response.env;
    return response.env;
}

export default {initEnv, DEV_ENV, PROD_ENV};
