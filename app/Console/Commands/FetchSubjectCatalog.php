<?php

namespace App\Console\Commands;

use App\Objects\StubaSubjectCatalog;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;


class FetchSubjectCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stuba:fetch-catalog {--S|seeder : Write seeder file.} {--W|rewrite : Rewrite current seeder.} {--F|force : Do everything do not ask.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;


    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }


    public function handle()
    {
        if (!$this->option('rewrite') && !$this->option('force')) {
            $this->ensureSeederDoesntAlreadyExist('SubjectSeeder');
        }

        $catalog = new StubaSubjectCatalog();
        $this->info('Fetching catalog from remote...');
        $subjects = $catalog->getData();
        $this->info(count($subjects) . ' found.');

        $this->info('Fetching language mutations...');
        $bar = $this->output->createProgressBar(10);//count($subjects));

        $i = 0;
        foreach ($subjects as $key => $subject) {
            if ($i === 10) {
                break;
            }
            $i++;
            $subjects[$key]['sk'] = $catalog->getFreshSubjectData($subject['ais_id'], 'sk')['sk'];
            $bar->advance();
        }

        $bar->finish();
        $this->line('');

        if ($this->option('seeder') || $this->option('force')) {
            $this->info('Creating seeder...');
            $this->files->put($this->getSeedPath(), $this->populateStub($subjects));
            $this->info('Running composer dump-autoload...');
            exec('composer dump-autoload');

            $this->info('Seeder created, you may run following command to make magic happen.');
            $this->comment('$ php artisan db:seed --class=SubjectSeeder');
            if ($this->option('force') || $this->confirm('Do you want to run SubjectSeeder right now? [y|N]')) {
                $this->info('Running seeder...');
                $this->call('db:seed', ['--class' => 'SubjectSeeder']);
            }
        }
    }


    protected function ensureSeederDoesntAlreadyExist($name)
    {
        if (class_exists($name)) {
            throw new \InvalidArgumentException("A $name seeder already exists. Run it instead of re-fetching all data again.");
        }
    }

    protected function getSeedPath()
    {
        return $this->laravel->databasePath() . '/seeds/SubjectSeeder.php';
    }

    protected function populateStub($subjects)
    {
        $stub = $this->files->get(resource_path('stubs/seeder.stub'));

        $body = '';
        foreach ($subjects as $subject) {
            $body .= "        App\\Subject::create(json_decode('" . json_encode($subject,
                    JSON_HEX_QUOT | JSON_HEX_APOS) . "', true));\n";
        }

        $stub = str_replace(':body:', $body, $stub);
        $stub = str_replace(':generated:', date('Y/m/d - h:i:s'), $stub);

        return $stub;
    }
}
