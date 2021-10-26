<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025114715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, date_publication DATE NOT NULL, pourvu TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, is_friendly TINYINT(1) NOT NULL, is_adopted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chien_race (chien_id INT NOT NULL, race_id INT NOT NULL, INDEX IDX_5B5D7EE8BFCF400E (chien_id), INDEX IDX_5B5D7EE86E59D40D (race_id), PRIMARY KEY(chien_id, race_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_adoption (id INT AUTO_INCREMENT NOT NULL, date_envoie DATE NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, date_envoie DATE NOT NULL, lue TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_5B5D7EE8BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chien_race ADD CONSTRAINT FK_5B5D7EE86E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD chien_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id)');
        $this->addSql('CREATE INDEX IDX_14B78418BFCF400E ON photo (chien_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chien_race DROP FOREIGN KEY FK_5B5D7EE8BFCF400E');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418BFCF400E');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE chien');
        $this->addSql('DROP TABLE chien_race');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE demande_adoption');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP INDEX IDX_14B78418BFCF400E ON photo');
        $this->addSql('ALTER TABLE photo DROP chien_id');
    }
}
