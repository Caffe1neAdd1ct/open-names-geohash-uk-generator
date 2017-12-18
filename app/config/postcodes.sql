CREATE TABLE `postcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postcode` varchar(255) NOT NULL,
  `area_code` varchar(5) NOT NULL,
  `district_code` varchar(3) NOT NULL,
  `geometry_x` varchar(255) NOT NULL,
  `geometry_y` varchar(255) NOT NULL,
  `lat_x` varchar(255) DEFAULT NULL,
  `lng_y` varchar(255) DEFAULT NULL,
  `geohash` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
