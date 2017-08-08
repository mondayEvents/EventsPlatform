<?php
$baseDir = dirname(dirname(__FILE__));
return [
    'plugins' => [
        'ADmad/JwtAuth' => $baseDir . '/vendor/admad/cakephp-jwt-auth/',
        'AssetCompress' => $baseDir . '/vendor/markstory/asset_compress/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'IdeHelper' => $baseDir . '/vendor/dereuromark/cakephp-ide-helper/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
        'MiniAsset' => $baseDir . '/vendor/markstory/mini-asset/'
    ]
];