ALTER TABLE `go_users` ADD `yubico_client_id` INT(11) NULL ;
ALTER TABLE `go_users` ADD `yubico_key` VARCHAR(50) NULL ;
ALTER TABLE `go_users` ADD `yubico_prefix` VARCHAR(12) NULL ;