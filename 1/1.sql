CREATE TABLE IF NOT EXISTS `c_items` (
  `id` int(11) NOT NULL PRIMARY KEY,
  `type` varchar(255),
  `metro` int(11) NOT NULL,
  `direction` int(11) NOT NULL,
  `deleted` char(1) NOT NULL DEFAULT 'N',
  KEY `metro` (`metro`),
  KEY `direction` (`direction`)
);

CREATE TABLE IF NOT EXISTS `l_metros` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255)
);

CREATE TABLE IF NOT EXISTS `l_directions` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255),
  `display` char(1) NOT NULL DEFAULT 'Y',
);
