<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025115847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD annonceur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C8764012 FOREIGN KEY (annonceur_id) REFERENCES annonceur (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5C8764012 ON annonce (annonceur_id)');
        $this->addSql('ALTER TABLE chien ADD annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chien ADD CONSTRAINT FK_13A4067E8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_13A4067E8805AB2F ON chien (annonce_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C8764012');
        $this->addSql('DROP INDEX IDX_F65593E5C8764012 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP annonceur_id');
        $this->addSql('ALTER TABLE chien DROP FOREIGN KEY FK_13A4067E8805AB2F');
        $this->addSql('DROP INDEX IDX_13A4067E8805AB2F ON chien');
        $this->addSql('ALTER TABLE chien DROP annonce_id');
    }
}
