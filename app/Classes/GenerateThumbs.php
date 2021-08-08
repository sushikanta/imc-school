<?php
/**
 * Created by PhpStorm.
 * User: ashish
 * Date: 21/8/15
 * Time: 2:57 PM
 */

namespace App\Classes;
use Illuminate\Contracts\Bus\SelfHandling;

class GenerateThumbs extends Command implements SelfHandling
{

    private $filePath;
    private $preset;
    private $config;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($filePath, $preset, $config)
    {

        $this->filePath = $filePath;
        $this->preset = $preset;
        $this->config = $config;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        return \Image::generateThumbs($this->filePath, $this->preset, $this->config);
    }

}