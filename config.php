<?php return array (
  'application' => 
  array (
    'debug' => true,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'mysql' => 
      array (
        'host' => 'localhost',
        'user' => 'pagekit_user',
        'password' => 'C0nn3ct3d!',
        'dbname' => 'armstrong_bcm_pagekit',
        'prefix' => 'pk_',
      ),
    ),
  ),
  'system' => 
  array (
    'secret' => 'MQf6nzPPhj22hsgca/pYP8Z6qcPaKgvw48rGnuIqf1Sfp4O4uToYzi1VXzp1HiD1',
  ),
  'system/cache' => 
  array (
    'caches' => 
    array (
      'cache' => 
      array (
        'storage' => 'auto',
      ),
    ),
    'nocache' => true,
  ),
  'system/finder' => 
  array (
    'storage' => '',
  ),
  'debug' => 
  array (
    'enabled' => true,
  ),
);