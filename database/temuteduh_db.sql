-- Skema database TemuTeduh
CREATE DATABASE IF NOT EXISTS `temuteduh_db` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `temuteduh_db`;

-- Matikan cek foreign key
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `animal_vaccine`;
DROP TABLE IF EXISTS `animals`;
DROP TABLE IF EXISTS `vaccines`;
DROP TABLE IF EXISTS `shelters`;

-- Aktifkan cek foreign key
SET FOREIGN_KEY_CHECKS = 1;

-- Tabel master data shelter
CREATE TABLE `shelters` (
    `id` VARCHAR(10) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel master jenis vaksin
CREATE TABLE `vaccines` (
    `id` VARCHAR(10) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel utama data hewan
CREATE TABLE `animals` (
    `id` VARCHAR(10) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `shelter_id` VARCHAR(10) NOT NULL,
    `age` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `idx_animals_shelter` (`shelter_id`),
    CONSTRAINT `fk_animals_shelter` FOREIGN KEY (`shelter_id`) 
        REFERENCES `shelters` (`id`) 
        ON UPDATE CASCADE 
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel pivot hewan vaksin
CREATE TABLE `animal_vaccine` (
    `animal_id` VARCHAR(10) NOT NULL,
    `vaccine_id` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`animal_id`, `vaccine_id`),
    INDEX `idx_av_animal` (`animal_id`),
    INDEX `idx_av_vaccine` (`vaccine_id`),
    CONSTRAINT `fk_av_animal` FOREIGN KEY (`animal_id`) 
        REFERENCES `animals` (`id`) 
        ON UPDATE CASCADE 
        ON DELETE CASCADE,
    CONSTRAINT `fk_av_vaccine` FOREIGN KEY (`vaccine_id`) 
        REFERENCES `vaccines` (`id`) 
        ON UPDATE CASCADE 
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data sampel master shelter
INSERT INTO `shelters` (`id`, `name`) VALUES
('SH001', 'Shelter Melati Harmoni'),
('SH002', 'Rumah Singgah Sahabat Satwa'),
('SH003', 'Suaka Fauna Sejahtera'),
('SH004', 'Kasih Sayang Animal Care');

-- Data sampel master vaksin
INSERT INTO `vaccines` (`id`, `name`) VALUES
('VK001', 'Rabies'),
('VK002', 'Distemper'),
('VK003', 'Parvovirus'),
('VK004', 'Hepatitis Hewan (Adenovirus)'),
('VK005', 'Leptospirosis');

-- Data sampel utama hewan
INSERT INTO `animals` (`id`, `name`, `shelter_id`, `age`) VALUES
('AN001', 'Boni', 'SH001', 2),
('AN002', 'Moka', 'SH001', 1),
('AN003', 'Kuro', 'SH002', 3),
('AN004', 'Bella', 'SH002', 4),
('AN005', 'Simba', 'SH003', 2),
('AN006', 'Milo', 'SH004', 1);

-- Data sampel relasi vaksin
INSERT INTO `animal_vaccine` (`animal_id`, `vaccine_id`) VALUES
('AN001', 'VK001'),
('AN001', 'VK002'),
('AN002', 'VK002'),
('AN002', 'VK003'),
('AN003', 'VK001'),
('AN003', 'VK005'),
('AN004', 'VK001'),
('AN004', 'VK002'),
('AN004', 'VK003'),
('AN005', 'VK003'),
('AN006', 'VK001'),
('AN006', 'VK004');
