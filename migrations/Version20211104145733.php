<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104145733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce CHANGE date_publication date_publication DATETIME NOT NULL');
        $this->addSql('ALTER TABLE demande_adoption CHANGE date_envoie date_envoie DATETIME NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE date_envoie date_envoie DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce CHANGE date_publication date_publication DATE NOT NULL');
        $this->addSql('ALTER TABLE demande_adoption CHANGE date_envoie date_envoie DATE NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE date_envoie date_envoie DATE NOT NULL');
    }
}
