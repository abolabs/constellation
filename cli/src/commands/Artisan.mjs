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
import { selectAction } from './Base.mjs';
import AbstractCommand from './AbstractCommand.mjs';

const actions = [
    'clear-compiled',
    'completion',
    'db',
    'down',
    'env',
    'help',
    'inspire',
    'list',
    'migrate',
    'optimize',
    'serve',
    'test',
    'tinker',
    'ui',
    'up',
    'auditing:audit-driver',
    'auditing:install',
    'auth:clear-resets',
    'cache:clear',
    'cache:forget',
    'cache:table',
    'claim:generate',
    'config:cache',
    'config:clear',
    'datatables:editor',
    'datatables:html',
    'datatables:make',
    'datatables:scope',
    'db:seed',
    'db:wipe',
    'debugbar:clear',
    'event:cache',
    'event:clear',
    'event:generate',
    'event:list',
    'infyom:api',
    'infyom:api_scaffold',
    'infyom:migration',
    'infyom:model',
    'infyom:publish',
    'infyom:repository',
    'infyom:rollback',
    'infyom:scaffold',
    'infyom.api:controller',
    'infyom.api:requests',
    'infyom.api:tests',
    'infyom.publish:generator-builder',
    'infyom.publish:layout',
    'infyom.publish:templates',
    'infyom.publish:user',
    'infyom.scaffold:controller',
    'infyom.scaffold:requests',
    'infyom.scaffold:views',
    'key:generate',
    'lang:js',
    'make:cast',
    'make:channel',
    'make:command',
    'make:component',
    'make:controller',
    'make:event',
    'make:exception',
    'make:export',
    'make:factory',
    'make:import',
    'make:job',
    'make:listener',
    'make:mail',
    'make:middleware',
    'make:migration',
    'make:model',
    'make:notification',
    'make:observer',
    'make:policy',
    'make:provider',
    'make:request',
    'make:resource',
    'make:rule',
    'make:scope',
    'make:seeder',
    'make:test',
    'make:transformer',
    'migrate:fresh',
    'migrate:install',
    'migrate:refresh',
    'migrate:reset',
    'migrate:rollback',
    'migrate:status',
    'model:prune',
    'notifications:table',
    'optimize:clear',
    'package:discover',
    'passport:client',
    'passport:hash',
    'passport:install',
    'passport:keys',
    'passport:purge',
    'permission:cache-reset',
    'permission:create-permission',
    'permission:create-role',
    'permission:setup-teams',
    'permission:show',
    'queue:batches-table',
    'queue:clear',
    'queue:failed',
    'queue:failed-table',
    'queue:flush',
    'queue:forget',
    'queue:listen',
    'queue:monitor',
    'queue:prune-batches',
    'queue:prune-failed',
    'queue:restart',
    'queue:retry',
    'queue:retry-batch',
    'queue:table',
    'queue:work',
    'route:cache',
    'route:clear',
    'route:list',
    'sail:install',
    'sail:publish',
    'schedule:clear-cache',
    'schedule:list',
    'schedule:run',
    'schedule:test',
    'schedule:work',
    'schema:dump',
    'session:table',
    'storage:link',
    'stub:publish',
    'translate:files',
    'ui:auth',
    'ui:controllers',
    'vendor:publish',
    'view:cache',
    'view:clear'
];

export default class Artisan extends AbstractCommand {

    usage() {
        const usageText = `
        Constellation CLI utils.

        Usage: constellation-cli artisan [OPTIONS] COMMAND

        Options:

            -h, --help            Display help for the given command. When no command is given display help for the list command
            -q, --quiet           Do not output any message
            -V, --version         Display this application version
                --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
            -n, --no-interaction  Do not ask any interactive question
                --env[=ENV]       The environment the command should run under
            -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

        Management Commands:

            clear-compiled                    Remove the compiled class file
            completion                        Dump the shell completion script
            db                                Start a new database CLI session
            down                              Put the application into maintenance / demo mode
            env                               Display the current framework environment
            help                              Display help for a command
            inspire                           Display an inspiring quote
            list                              List commands
            migrate                           Run the database migrations
            optimize                          Cache the framework bootstrap files
            serve                             Serve the application on the PHP development server
            test                              Run the application tests
            tinker                            Interact with your application
            ui                                Swap the front-end scaffolding for the application
            up                                Bring the application out of maintenance mode
        auditing
            auditing:audit-driver             Create a new audit driver
            auditing:install                  Install all of the Auditing resources
        auth
            auth:clear-resets                 Flush expired password reset tokens
        cache
            cache:clear                       Flush the application cache
            cache:forget                      Remove an item from the cache
            cache:table                       Create a migration for the cache database table
        claim
            claim:generate                    Create a new JWT Claim class
        config
            config:cache                      Create a cache file for faster configuration loading
            config:clear                      Remove the configuration cache file
        datatables
            datatables:editor                 Create a new DataTables Editor class.
            datatables:html                   Create a new DataTable html class.
            datatables:make                   Create a new DataTable service class.
            datatables:scope                  Create a new DataTable Scope class.
        db
            db:seed                           Seed the database with records
            db:wipe                           Drop all tables, views, and types
        debugbar
            debugbar:clear                    Clear the Debugbar Storage
        event
            event:cache                       Discover and cache the application's events and listeners
            event:clear                       Clear all cached events and listeners
            event:generate                    Generate the missing events and listeners based on registration
            event:list                        List the application's events and listeners
        infyom
            infyom:api                        Create a full CRUD API for given model
            infyom:api_scaffold               Create a full CRUD API and Scaffold for given model
            infyom:migration                  Create migration command
            infyom:model                      Create model command
            infyom:publish                    Publishes & init api routes, base controller, base test cases traits.
            infyom:repository                 Create repository command
            infyom:rollback                   Rollback a full CRUD API and Scaffold for given model
            infyom:scaffold                   Create a full CRUD views for given model
        infyom.api
            infyom.api:controller             Create an api controller command
            infyom.api:requests               Create an api request command
            infyom.api:tests                  Create tests command
        infyom.publish
            infyom.publish:generator-builder  Publishes routes for generator builder and published views.
            infyom.publish:layout             Publishes auth files
            infyom.publish:templates          Publishes api generator templates.
            infyom.publish:user               Publishes Users CRUD file
        infyom.scaffold
            infyom.scaffold:controller        Create controller command
            infyom.scaffold:requests          Create a full CRUD views for given model
            infyom.scaffold:views             Create views file command
        key
            key:generate                      Set the application key
        lang
            lang:js                           Generate JS lang files.
        make
            make:cast                         Create a new custom Eloquent cast class
            make:channel                      Create a new channel class
            make:command                      Create a new Artisan command
            make:component                    Create a new view component class
            make:controller                   Create a new controller class
            make:event                        Create a new event class
            make:exception                    Create a new custom exception class
            make:export                       Create a new export class
            make:factory                      Create a new model factory
            make:import                       Create a new import class
            make:job                          Create a new job class
            make:listener                     Create a new event listener class
            make:mail                         Create a new email class
            make:middleware                   Create a new middleware class
            make:migration                    Create a new migration file
            make:model                        Create a new Eloquent model class
            make:notification                 Create a new notification class
            make:observer                     Create a new observer class
            make:policy                       Create a new policy class
            make:provider                     Create a new service provider class
            make:request                      Create a new form request class
            make:resource                     Create a new resource
            make:rule                         Create a new validation rule
            make:scope                        Create a new scope class
            make:seeder                       Create a new seeder class
            make:test                         Create a new test class
            make:transformer                  Create a new Transformer Class
        migrate
            migrate:fresh                     Drop all tables and re-run all migrations
            migrate:install                   Create the migration repository
            migrate:refresh                   Reset and re-run all migrations
            migrate:reset                     Rollback all database migrations
            migrate:rollback                  Rollback the last database migration
            migrate:status                    Show the status of each migration
        model
            model:prune                       Prune models that are no longer needed
        notifications
            notifications:table               Create a migration for the notifications table
        optimize
            optimize:clear                    Remove the cached bootstrap files
        package
            package:discover                  Rebuild the cached package manifest
        passport
            passport:client                   Create a client for issuing access tokens
            passport:hash                     Hash all of the existing secrets in the clients table
            passport:install                  Run the commands necessary to prepare Passport for use
            passport:keys                     Create the encryption keys for API authentication
            passport:purge                    Purge revoked and / or expired tokens and authentication codes
        permission
            permission:cache-reset            Reset the permission cache
            permission:create-permission      Create a permission
            permission:create-role            Create a role
            permission:setup-teams            Setup the teams feature by generating the associated migration.
            permission:show                   Show a table of roles and permissions per guard
        queue
            queue:batches-table               Create a migration for the batches database table
            queue:clear                       Delete all of the jobs from the specified queue
            queue:failed                      List all of the failed queue jobs
            queue:failed-table                Create a migration for the failed queue jobs database table
            queue:flush                       Flush all of the failed queue jobs
            queue:forget                      Delete a failed queue job
            queue:listen                      Listen to a given queue
            queue:monitor                     Monitor the size of the specified queues
            queue:prune-batches               Prune stale entries from the batches database
            queue:prune-failed                Prune stale entries from the failed jobs table
            queue:restart                     Restart queue worker daemons after their current job
            queue:retry                       Retry a failed queue job
            queue:retry-batch                 Retry the failed jobs for a batch
            queue:table                       Create a migration for the queue jobs database table
            queue:work                        Start processing jobs on the queue as a daemon
        route
            route:cache                       Create a route cache file for faster route registration
            route:clear                       Remove the route cache file
            route:list                        List all registered routes
        sail
            sail:install                      Install Laravel Sail's default Docker Compose file
            sail:publish                      Publish the Laravel Sail Docker files
        schedule
            schedule:clear-cache              Delete the cached mutex files created by scheduler
            schedule:list                     List the scheduled commands
            schedule:run                      Run the scheduled commands
            schedule:test                     Run a scheduled command
            schedule:work                     Start the schedule worker
        schema
            schema:dump                       Dump the given database schema
        session
            session:table                     Create a migration for the session database table
        storage
            storage:link                      Create the symbolic links configured for the application
        stub
            stub:publish                      Publish all stubs that are available for customization
        translate
            translate:files                   Translate Translation files. translate:files
        ui
            ui:auth                           Scaffold basic login and registration views and routes
            ui:controllers                    Scaffold the authentication controllers
        vendor
            vendor:publish                    Publish any publishable assets from vendor packages
        view
            view:cache                        Compile all of the application's Blade templates
            view:clear                        Clear all compiled view files

        `
        Console.log(usageText);
    }

    async run() {
        if (!actions.includes(this.action)) {
            this.usage();
            if (!(this.action = await selectAction(actions))) {
                Console.error('No action selected');
                process.exit(1);
            }
        }

        cd(path.join(this.cliEnv?.rootDir, 'install', process.env.APP_ENV));
        $`docker compose exec -it --user constellation_user api php artisan ${this.action} ${this.additional}`
            .pipe(process.stdout)
            .catch((p) => {
                Console.printError(p);
                process.exit(1);
            });
    }
}

