<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\AssetOfDepreciation;

class DepreciationCommand extends Command
{
    use AssetOfDepreciation;
    
    protected $signature = 'create:depreciation';

    
    protected $description = 'Command description';

   
    public function __construct()
    {
        parent::__construct();
    }

   
    public function handle()
    {
        $this->createYearlyDepreciation();
        return 0;
    }
}
