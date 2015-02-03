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
// Artisan::add(new UcGame);
Artisan::add(new CollectGame);
Artisan::add(new DownloadLogsTable);
Artisan::add(new Statistics);
Artisan::add(new OldToNew);
Artisan::add(new FixAppTags);
Artisan::add(new FixAppMd5);
Artisan::add(new FixUcInfo);
Artisan::add(new ExportAnything);
Artisan::add(new NewCats);
Artisan::add(new MoveAppTableToGameTable);
Artisan::add(new NewAds);
