CREATE TABLE persons (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `last_name` varchar(255) NOT NULL,
    `first_name` varchar(255) NOT NULL,
    `middle_name` varchar(255) DEFAULT NULL,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE phones (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `person_id` int(11) NOT NULL,
    `number` varchar(18) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `number` (`number`),
    KEY `person_id` (`person_id`),
    CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `persons` (`last_name`, `first_name`, `middle_name`) VALUES
('Иванов', 'Иван', 'Иванович'),
('Петров', 'Петр', 'Петрович'),
('Сидоров', 'Василий', 'Николаевич');

INSERT INTO `phones` (`person_id`, `number`) VALUES
('1', '+7 (987) 55-667-77'),
('2', '+7 (976) 77-555-77'),
('2', '+7 (965) 44-333-22'),
('3', '+7 (954) 22-543-11'),
('3', '+7 (943) 12-245-67'),
('3', '+7 (932) 76-543-21');