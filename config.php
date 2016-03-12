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
    'secret' => 'XTa0Y9C01e8YgUgXfmWPPJtJqdwQEkcCu0cC4OhXYLi/1.PKYtZLn0.LH.r5U0yS',
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