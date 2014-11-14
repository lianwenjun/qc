<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
Artisan::add(new UcGame);
Artisan::add(new CollectGame);
<<<<<<< HEAD
Artisan::add(new Statistics);
=======
Artisan::add(new DownloadLogsTable);
>>>>>>> b437248f6fa911a99c196f40ddd40d2d78223bf6
