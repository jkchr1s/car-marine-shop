<?php

namespace App\Console\Commands;

use App\CustomerType;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InitDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('------------');
        $this->info('CustomerType');
        $this->info('------------');

        // check for personal
        try {
            CustomerType::where('type', 'Personal')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->info('Creating customer type: "Personal"');
            $item = new CustomerType();
            $item->type = 'Personal';
            $item->saveOrFail();
        }

        // check for business
        try {
            CustomerType::where('type', 'Business')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $this->info('Creating customer type: "Business"');
            $item = new CustomerType();
            $item->type = 'Business';
            $item->saveOrFail();
        }
        $this->info('Table "CustomerType" is ready.');


    }
}
