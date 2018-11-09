<?php

Config::set('site_name', 'Тестовый сайт');

Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.db_name', 'mvc');

Config::set('salt', '7zE(J73^K7aEvu$<');
Config::set('pages_in_pagination', '5');
