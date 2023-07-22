<?php

use App\Models\Application;
use App\Models\Audit;
use App\Models\Environment;
use App\Models\Hosting;
use App\Models\HostingType;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Models\ServiceVersion;
use App\Models\Team;
use App\Models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Search Engine
    |--------------------------------------------------------------------------
    |
    | This option controls the default search connection that gets used while
    | using Laravel Scout. This connection is used when syncing all models
    | to the search service. You should adjust this based on your needs.
    |
    | Supported: "algolia", "meilisearch", "database", "collection", "null"
    |
    */

    'driver' => env('SCOUT_DRIVER', 'meilisearch'),

    /*
    |--------------------------------------------------------------------------
    | Index Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify a prefix that will be applied to all search index
    | names used by Scout. This prefix may be useful if you have multiple
    | "tenants" or applications sharing the same search infrastructure.
    |
    */

    'prefix' => env('SCOUT_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Queue Data Syncing
    |--------------------------------------------------------------------------
    |
    | This option allows you to control if the operations that sync your data
    | with your search engines are queued. When this is set to "true" then
    | all automatic data syncing will get queued for better performance.
    |
    */

    'queue' => env('SCOUT_QUEUE', true),

    /*
    |--------------------------------------------------------------------------
    | Database Transactions
    |--------------------------------------------------------------------------
    |
    | This configuration option determines if your data will only be synced
    | with your search indexes after every open database transaction has
    | been committed, thus preventing any discarded data from syncing.
    |
    */

    'after_commit' => false,

    /*
    |--------------------------------------------------------------------------
    | Chunk Sizes
    |--------------------------------------------------------------------------
    |
    | These options allow you to control the maximum chunk size when you are
    | mass importing data into the search engine. This allows you to fine
    | tune each of these chunk sizes based on the power of the servers.
    |
    */

    'chunk' => [
        'searchable' => 500,
        'unsearchable' => 500,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    |
    | This option allows to control whether to keep soft deleted records in
    | the search indexes. Maintaining soft deleted records can be useful
    | if your application still needs to search for the records later.
    |
    */

    'soft_delete' => false,

    /*
    |--------------------------------------------------------------------------
    | Identify User
    |--------------------------------------------------------------------------
    |
    | This option allows you to control whether to notify the search engine
    | of the user performing the search. This is sometimes useful if the
    | engine supports any analytics based on this application's users.
    |
    | Supported engines: "algolia"
    |
    */

    'identify' => env('SCOUT_IDENTIFY', false),

    /*
    |--------------------------------------------------------------------------
    | Algolia Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Algolia settings. Algolia is a cloud hosted
    | search engine which works great with Scout out of the box. Just plug
    | in your application ID and admin API key to get started searching.
    |
    */

    'algolia' => [
        'id' => env('ALGOLIA_APP_ID', ''),
        'secret' => env('ALGOLIA_SECRET', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | MeiliSearch Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your MeiliSearch settings. MeiliSearch is an open
    | source search engine with minimal configuration. Below, you can state
    | the host and key information for your own MeiliSearch installation.
    |
    | See: https://docs.meilisearch.com/guides/advanced_guides/configuration.html
    |
    */

    'meilisearch' => [
        'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
        'key' => env('MEILISEARCH_KEY', null),
        'index-settings' => [
            Application::class => [
                'filterableAttributes' => [
                    'id',
                    'team_id',
                    'name',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                    'user_type',
                    'user_id',
                    'user_name',
                    'event',
                    'auditable_type',
                    'ip_address',
                    'created_at',
                ],
            ],
            Audit::class => [
                'filterableAttributes' => [
                    'user_id',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                    'team_name',
                ],
            ],
            Environment::class => [
                'filterableAttributes' => [
                    'id',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                ],
            ],
            Hosting::class => [
                'filterableAttributes' => [
                    'id',
                    'hosting_type_id',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                    'hosting_type_id',
                    'hosting_type_name',
                    'localisation',
                ],
            ],
            HostingType::class => [
                'filterableAttributes' => [
                    'id',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                    'description',
                ],
            ],
            Permission::class => [
                'filterableAttributes' => [
                    'id',
                    'name',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                ],
            ],
            Role::class => [
                'filterableAttributes' => [
                    'id',
                    'name',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                ],
            ],
            Service::class => [
                'filterableAttributes' => [
                    'id',
                    'team_id',
                ],
                'sortableAttributes' => [
                    'id',
                    'team_id',
                    'name',
                    'git_repo',
                ],
            ],
            ServiceInstance::class => [
                'filterableAttributes' => [
                    'id',
                    'environment_id',
                    'hosting_name',
                    'hosting_id',
                    'application_name',
                ],
                'sortableAttributes' => [
                    'id',
                    'application_name',
                    'service_name',
                    'service_version_name',
                    'service_version',
                    'environment_name',
                    'hosting_name',
                    'role',
                    'statut',
                ],
            ],
            ServiceInstanceDependencies::class => [
                'filterableAttributes' => [
                    'id',
                ],
                'sortableAttributes' => [
                    'id',
                    'instance_id',
                    'instance_dep_id',
                    'level',
                    'description',
                ],
            ],
            ServiceVersion::class => [
                'filterableAttributes' => [
                    'id',
                    'service_id',
                ],
                'sortableAttributes' => [
                    'id',
                    'service_id',
                    'version',
                    'service_name',
                ],
            ],
            Team::class => [
                'filterableAttributes' => [
                    'id',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                ],
            ],
            User::class => [
                'filterableAttributes' => [
                    'id',
                ],
                'sortableAttributes' => [
                    'id',
                    'name',
                    'email',
                ],
            ],
        ],
    ],

];
