<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RefreshAllIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-all-indexes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all existing indexes, reset configuration and re-import all data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('scout:delete-all-indexes');
        $this->call('scout:sync-index-settings');
        $this->call('scout:import', ['model' => 'App\\Models\\Application']);
        $this->call('scout:import', ['model' => 'App\\Models\\Audit']);
        $this->call('scout:import', ['model' => 'App\\Models\\Environment']);
        $this->call('scout:import', ['model' => 'App\\Models\\Hosting']);
        $this->call('scout:import', ['model' => 'App\\Models\\HostingType']);
        $this->call('scout:import', ['model' => 'App\\Models\\Permission']);
        $this->call('scout:import', ['model' => 'App\\Models\\Role']);
        $this->call('scout:import', ['model' => 'App\\Models\\Service']);
        $this->call('scout:import', ['model' => 'App\\Models\\ServiceInstance']);
        $this->call('scout:import', ['model' => 'App\\Models\\ServiceInstanceDependencies']);
        $this->call('scout:import', ['model' => 'App\\Models\\ServiceVersion']);
        $this->call('scout:import', ['model' => 'App\\Models\\Team']);
        $this->call('scout:import', ['model' => 'App\\Models\\User']);
    }
}
