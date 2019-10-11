<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class createCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create all available categories';

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
        $this->info('Creating Default Categories');
        $category = new Category();
        $categoriesArray = config('default.categories');
        foreach($categoriesArray as $cat){
            $newCategory = $category->create($cat);
        }
        $this->info('Created All Categories');
    }
}
