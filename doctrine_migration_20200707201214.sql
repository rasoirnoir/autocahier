-- Doctrine Migration File Generated on 2020-07-07 20:12:14

-- Version 20200305221125
ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id);
CREATE INDEX IDX_8D93D649D60322AC ON user (role_id);
INSERT INTO migration_versions (version, executed_at) VALUES ('20200305221125', CURRENT_TIMESTAMP);

-- Version 20200707130807
CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
INSERT INTO migration_versions (version, executed_at) VALUES ('20200707130807', CURRENT_TIMESTAMP);

-- Version 20200707131046
CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
INSERT INTO migration_versions (version, executed_at) VALUES ('20200707131046', CURRENT_TIMESTAMP);

-- Version 20200707200734
CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, postal_code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE pdi (id INT AUTO_INCREMENT NOT NULL, tournee_id_id INT NOT NULL, libelle_id_id INT NOT NULL, numero VARCHAR(255) NOT NULL, client_name VARCHAR(255) NOT NULL, is_depot TINYINT(1) NOT NULL, is_reex TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, ordre INT NOT NULL, format VARCHAR(255) NOT NULL, INDEX IDX_9E4FC61DC3AC4C3E (tournee_id_id), INDEX IDX_9E4FC61DB193E41D (libelle_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE libelle (id INT AUTO_INCREMENT NOT NULL, ville_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A4D60759F0C17188 (ville_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE tournee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE pdi ADD CONSTRAINT FK_9E4FC61DC3AC4C3E FOREIGN KEY (tournee_id_id) REFERENCES tournee (id);
ALTER TABLE pdi ADD CONSTRAINT FK_9E4FC61DB193E41D FOREIGN KEY (libelle_id_id) REFERENCES libelle (id);
ALTER TABLE libelle ADD CONSTRAINT FK_A4D60759F0C17188 FOREIGN KEY (ville_id_id) REFERENCES ville (id);
INSERT INTO migration_versions (version, executed_at) VALUES ('20200707200734', CURRENT_TIMESTAMP);