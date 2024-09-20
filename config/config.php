<?php
$CONFIG = array (
  'htaccess.RewriteBase' => '/',
  'cors.allowed-domains' => [
    'http://localhost:3000',
  ],
  'memcache.local' => '\\OC\\Memcache\\APCu',
  'apps_paths' => 
  array (
    0 => 
    array (
      'path' => '/var/www/html/apps',
      'url' => '/apps',
      'writable' => false,
    ),
    1 => 
    array (
      'path' => '/var/www/html/custom_apps',
      'url' => '/custom_apps',
      'writable' => true,
    ),
  ),
  'upgrade.disable-web' => true,
  'instanceid' => 'ocsnakekqfac',
  'passwordsalt' => 'xsQ+1ViayMKFcmV6Uu3W/AassXiIin',
  'secret' => 'Tgk6gll3nDOZan6bR7dPreeRJTaZpmd+TjASC6Mjxlc5fSWZ',
  'trusted_domains' => 
  array (
    0 => 'localhost:8080',
  ),
  'datadirectory' => '/var/www/html/data',
  'dbtype' => 'mysql',
  'version' => '30.0.0.14',
  'overwrite.cli.url' => 'http://localhost:8080',
  'dbname' => 'nextcloud',
  'dbhost' => 'db',
  'dbport' => '',
  'dbtableprefix' => 'oc_',
  'mysql.utf8mb4' => true,
  'dbuser' => 'nextclouduser',
  'dbpassword' => 'secretpassword',
  'installed' => true,
  'app_install_overwrite' => 
  array (
    0 => 'customfilebrowser',
  ),
  'allow_local_remote_servers' => true,
);
