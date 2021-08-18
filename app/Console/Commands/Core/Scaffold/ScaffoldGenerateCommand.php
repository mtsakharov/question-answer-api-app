<?php

namespace App\Console\Commands\Core\Scaffold;

use Illuminate\Console\Command;

class ScaffoldGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaffold:generate {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $structureName = $this->argument('name');
        if ($structureName) {
            $this->call('make:model', ['name' => $structureName, '--all' => 'default']);
            $this->call('make:request', ['name' => $structureName.'/'.'Store'.$structureName.'Request']);
            $this->call('make:request', ['name' => $structureName.'/'.'Update'.$structureName.'Request']);
            $this->call('make:resource', ['name' => $structureName.'Resource']);
            $this->call('make:test', ['name' => $structureName.'Test']);
            $this->info('The command was successful!');
        }
    }
}
