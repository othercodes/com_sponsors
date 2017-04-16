CREATE TABLE IF NOT EXISTS `#__dev_sponsors_profile` (
  `id`               INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id`         INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `name`             VARCHAR(255)     NOT NULL,
  `alias`            VARCHAR(255)
                     COLLATE utf8_bin NOT NULL,
  `cif`              VARCHAR(255)     NOT NULL,
  `titular`          INT(11)          NOT NULL DEFAULT '0',
  `address`          TEXT             NOT NULL,
  `url`              VARCHAR(255)     NOT NULL,
  `zip`              VARCHAR(255)     NOT NULL,
  `city`             VARCHAR(255)     NOT NULL,
  `region`           VARCHAR(255)     NOT NULL,
  `country`          VARCHAR(255)     NOT NULL,
  `email`            VARCHAR(255)     NOT NULL,
  `phone`            VARCHAR(255)     NOT NULL,
  `facebook`         VARCHAR(255)     NOT NULL,
  `twitter`          VARCHAR(255)     NOT NULL,
  `youtube`          VARCHAR(255)     NOT NULL,
  `vip`              TINYINT(1)       NOT NULL DEFAULT '0',
  `fido`             TINYINT(1)       NOT NULL DEFAULT '0',
  `banner1`          VARCHAR(255)     NOT NULL,
  `banner2`          VARCHAR(255)     NOT NULL,
  `ordering`         INT(11)          NOT NULL DEFAULT '0',
  `checked_out`      INT(11)          NOT NULL DEFAULT '0',
  `checked_out_time` DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by`       INT(11)          NOT NULL DEFAULT '0',
  `modified_by`      INT(11)          NOT NULL DEFAULT '0',
  `state`            TINYINT(1)       NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT COLLATE = utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
  SELECT *
  FROM (SELECT
          'Profile',
          'com_sponsors.profile',
          '{"special":{"dbtable":"#__sponsors_profile","key":"id","type":"Profile","prefix":"SponsorsTable"}}',
          '{"formFile":"administrator\/components\/com_sponsors\/models\/forms\/profile.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"address"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
  WHERE NOT EXISTS(
      SELECT type_alias
      FROM `#__content_types`
      WHERE (`type_alias` = 'com_sponsors.profile')
  )
  LIMIT 1;
