DROP TABLE IF EXISTS `broadcasts`;
CREATE TABLE `broadcasts` (
    `programmeId` VARCHAR( 30 ) NOT NULL,
    `channelId` VARCHAR( 12 ) NOT NULL,
    `start` DATETIME NOT NULL,
    `duration` TIME NOT NULL,
    PRIMARY KEY( `programmeId`, `channelId`, `start`, `duration` ),
    KEY `programmeId_idx` ( `programmeId` )
);

DROP TABLE IF EXISTS `channels`;
CREATE TABLE `channels` (
    `channelId` VARCHAR( 12 ) NOT NULL,
    `name` VARCHAR( 25 ) NOT NULL,
    PRIMARY KEY( `channelId`, `name` ),
    KEY channelId_idx( `channelId` )
);

DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
    `programmeId` VARCHAR( 30 ) NOT NULL,
    `type` ENUM( 'multicast-real', 'multicast-wmv', 'multicast-h264',
                 'real-audio', 'windows-media', 'multicast-aac' ) NOT NULL,
    `url` VARCHAR( 100 ) NOT NULL,
    `start` DATETIME NOT NULL,
    `duration` TIME NOT NULL,
    PRIMARY KEY( `programmeId`, `type`, `url`, `start`, `duration` ),
    KEY `programmeId_idx` ( `programmeId` )
);

DROP TABLE IF EXISTS `logos`;
CREATE TABLE `logos` (
    `channelId` VARCHAR( 12 ) NOT NULL,
    `url` VARCHAR( 100 ) NOT NULL,
    PRIMARY KEY( `channelId`, `url` ),
    KEY `channelId_idx` ( `channelId` )
);

DROP TABLE IF EXISTS `programmes`;
CREATE TABLE `programmes` (
    `programmeId` VARCHAR( 30 ) NOT NULL,
    `title` VARCHAR( 40 ) NOT NULL,
    `synopsis` TEXT NOT NULL,
    PRIMARY KEY( `programmeId` )
);