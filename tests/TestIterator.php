<?php

require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$arr = [
  'users' => [
      ['name' => 'Marcos Dantas', 'city' => 'Parelhas', 'country' => 'Brazil', 'data' => ['comments' => ['2017-05' => 'someData', '08' => ['my comment blocks' => 'Dated']]], 'postId' => 30],
      ['name' => 'User Test', 'city' => 'TestCity', 'country' => 'Pequenopole']
  ],
  'posts' => [
      ['title' => 'Title Description', 'description' => 'some text of post!']
  ]
];


$iterator = new \SimpleIterator\Iterator($arr);


$iterator->register('everyOne', function($item){
   echo $item.PHP_EOL;
});

$iterator->register('data', function($item){
   print_r($item);
});

$iterator->iterate();

