CREATE TABLE `keys` (
`id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`api_key` varchar(255) NOT NULL,
`level` int(2) NOT NULL,
`ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
`is_private_key` tinyint(1) NOT NULL DEFAULT '0',
`ip_addresses` text,
`date_created` int(11) NOT NULL,
`api_key_activated` enum('yes','no') NOT NULL DEFAULT 'no'
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
