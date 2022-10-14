CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    PRIMARY KEY(`id`)
);

CREATE TABLE `wallets` (
    `wallet_id` INT(11) NOT NULL AUTO_INCREMENT,
    `amount` VARCHAR(45) NOT NULL,
    `user` INT(11) NOT NULL,
    PRIMARY KEY(`wallet_id`)
);


