<?php

namespace App\Console\Commands\Development;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class MakeBundleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bundle {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make model, migration, ressource and nova ressource';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $model = ucfirst(Str::singular($name));

        $this->call('make:policy', [
            'name'    => sprintf('%sPolicy', $model),
            '--model' => $model,
        ]);
        $this->call('nova:resource', [
            'name' => $model,
        ]);
        $this->call('make:controller', [
            'name' => 'Api\\'.$model.'Controller',
        ]);
        $this->call('make:resource', [
            'name' => $model.'Resource',
        ]);
        $this->call('make:model', [
            'name' => $model,
            '-m'   => true,
        ]);

        return SymfonyCommand::SUCCESS;
    }
}
