<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Lava\Products\SonicController;

class SonicCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:sonic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sonic Cron Job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $startTime = microtime(TRUE);
        //Intialize Sonic Controller
        $this->info('Intializing Sonic Controller');
        $sonicController = new SonicController();
        

        //Get sessions
        $sonicController->sonic();

        $endTime = microtime(TRUE);

        $timeTaken = ($endTime - $startTime) / 1000000;
        
        $this->info('Called Sonic API');
        $this->info('Time Taken: ' . $timeTaken . ' seconds');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('example', InputArgument::OPTIONAL, 'An example argument.'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('migrate', 0, InputOption::VALUE_NONE, 'Migrate', null)
        );
    }

}
