<?php
return [
  'routes' => [
    [
      'name' => 'api#getUserFiles',
      'url' => '/api/files',
      'verb' => 'GET',
    ],
    [
      'name' => 'api#optionsUserFiles',
      'url' => '/api/files',
      'verb' => 'OPTIONS',
    ],
    [
      'name' => 'api#downloadFile',
      'url' => '/api/files/download',
      'verb' => 'GET',
    ],
    [
      'name' => 'api#optionsDownloadFile',
      'url' => '/api/files/download',
      'verb' => 'OPTIONS',
    ],
  ],
];
