- Add new column in `openemr_postcalendar_events` table

```
ALTER TABLE `openemr_postcalendar_events` ADD `pc_roomlink` VARCHAR(128) NOT NULL AFTER `pc_room`;
```

- Create new table

```
CREATE TABLE IF NOT EXISTS `rooms` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) NOT NULL,
    `platform` enum('Terms','Zoom') NOT NULL,
    `room_link` varchar(512) NOT NULL,
    `active` int(1) NOT NULL DEFAULT '1',
    `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
