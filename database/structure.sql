CREATE TABLE `broadcasts` (
    `programmeId` VARCHAR( 30 ) NOT NULL,
    `channelId` VARCHAR( 12 ) NOT NULL,
    `start` DATETIME NOT NULL,
    `duration` TIME NOT NULL,
    PRIMARY KEY( `programmeId`, `channelId`, `start`, `duration` ),
    KEY `programmeId_idx` ( `programmeId` )
);

CREATE TABLE `locations` (
    `programmeId` VARCHAR( 30 ) NOT NULL,
    `type` ENUM( 'multicast-real', 'multicast-wmv', 'multicast-h264',
                 'real-audio', 'windows-media', 'multicast-aac' ) NOT NULL,
    `url` VARCHAR( 100 ) NOT NULL,
    PRIMARY KEY( `programmeId`, `type`, `url` ),
    KEY `programmeId_idx` ( `programmeId` )
);

CREATE TABLE `programmes` (
    `programmeId` VARCHAR( 30 ) NOT NULL,
    `title` VARCHAR( 40 ) NOT NULL,
    `synopsis` TEXT NOT NULL,
    PRIMARY KEY( `programmeId` )
);