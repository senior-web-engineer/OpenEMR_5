- Add new column in `openemr_postcalendar_events` table

```
ALTER TABLE `openemr_postcalendar_events` ADD `pc_roomlink` VARCHAR(128) NOT NULL AFTER `pc_room`;
```

- Create new table

```
CREATE TABLE `rooms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `platform` varchar(32) NOT NULL,
  `room_link` varchar(512) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

- Create room_platform

```

CREATE TABLE `room_platform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `platform` varchar(32) NOT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
