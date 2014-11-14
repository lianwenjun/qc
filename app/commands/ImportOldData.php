<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * old数据库数据导入到新qc数据库
 *
 * @author RavenLee
 */
class ImportOldData extends Command
{
    protected $name = 'import:old';

    protected $description = '';

    public function __construct() {}

    public function fire() {}

    protected function getArguments() {}
}