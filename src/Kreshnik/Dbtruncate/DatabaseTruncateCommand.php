<?php

namespace Kreshnik\Dbtruncate;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Symfony\Component\Console\Input\InputOption;

class DatabaseTruncateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate database tables.';
    /**
     * @var DatabaseManager
     */
    private $db;
    private $exclude = [];
    private $tables = [];
    private $truncatedCount = 0;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        parent::__construct();
        $this->db = $db;
        $this->exclude = [];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->tables = $this->option('tables');
        $this->setupExcludeTables();

        $this->setupTables();

        if ($this->confirm('Are you sure you want to truncate the tables? [yes|no]')) {
            $this->initializeTruncate();
        } else {
            $this->info('Command aborted.');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['tables', null, InputOption::VALUE_OPTIONAL, 'A list of tables divided with a comma', null],
            ['exclude', null, InputOption::VALUE_OPTIONAL, 'A list of tables to exclude from the truncation divided with a comma', null],
        ];
    }

    private function initializeTruncate()
    {
        $time = date('Y-m-d H:i:s');
        $this->info("Truncation started: {$time}");
        $this->truncateTables();
    }

    private function truncateTables()
    {
        $this->truncatedCount = 0;
        foreach ($this->tables as $table) {
            if (!in_array($table, $this->exclude)) {
                $this->truncatedCount++;
                $this->db->statement('SET FOREIGN_KEY_CHECKS=0;');
                $this->db->statement("TRUNCATE TABLE $table");
                $this->db->statement('SET FOREIGN_KEY_CHECKS=1;');
                $this->info("Table $table successfully truncated.");
            }
        }

        $time = date('Y-m-d H:i:s');
        $this->info("Truncation ended: {$time}");
        $this->info("Total table(s) truncated: {$this->truncatedCount}");
    }

    private function setupExcludeTables()
    {
        $exclude = $this->option('exclude');
        if (!is_null($exclude)) {
            $this->exclude = explode(',', $exclude);
        }
    }

    private function setupTables()
    {
        if ((!is_null($this->tables))) {
            $this->tables = explode(',', $this->tables);
        } else {
            $schema = $this->db->getDoctrineSchemaManager();
            $this->tables = $schema->listTableNames();
        }
    }
}
