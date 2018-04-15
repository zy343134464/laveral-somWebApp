<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use log;

class Clearpic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clearpic';

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
        Log::info('每分钟输出一次当前的日期时间到日志当中'.date('Y-m-d H:i:s'));
    }
}
