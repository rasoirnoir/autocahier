<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707200734 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, postal_code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pdi (id INT AUTO_INCREMENT NOT NULL, tournee_id_id INT NOT NULL, libelle_id_id INT NOT NULL, numero VARCHAR(255) NOT NULL, client_name VARCHAR(255) NOT NULL, is_depot TINYINT(1) NOT NULL, is_reex TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, ordre INT NOT NULL, format VARCHAR(255) NOT NULL, INDEX IDX_9E4FC61DC3AC4C3E (tournee_id_id), INDEX IDX_9E4FC61DB193E41D (libelle_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libelle (id INT AUTO_INCREMENT NOT NULL, ville_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A4D60759F0C17188 (ville_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pdi ADD CONSTRAINT FK_9E4FC61DC3AC4C3E FOREIGN KEY (tournee_id_id) REFERENCES tournee (id)');
        $this->addSql('ALTER TABLE pdi ADD CONSTRAINT FK_9E4FC61DB193E41D FOREIGN KEY (libelle_id_id) REFERENCES libelle (id)');
        $this->addSql('ALTER TABLE libelle ADD CONSTRAINT FK_A4D60759F0C17188 FOREIGN KEY (ville_id_id) REFERENCES ville (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE libelle DROP FOREIGN KEY FK_A4D60759F0C17188');
        $this->addSql('ALTER TABLE pdi DROP FOREIGN KEY FK_9E4FC61DB193E41D');
        $this->addSql('ALTER TABLE pdi DROP FOREIGN KEY FK_9E4FC61DC3AC4C3E');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE pdi');
        $this->addSql('DROP TABLE libelle');
        $this->addSql('DROP TABLE tournee');
        $this->addSql('DROP TABLE user');
    }
}
