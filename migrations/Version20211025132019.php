<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025132019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6BC8764012');
        $this->addSql('DROP INDEX IDX_AB87FF6BC8764012 ON demande_adoption');
        $this->addSql('ALTER TABLE demande_adoption DROP annonceur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_adoption ADD annonceur_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6BC8764012 FOREIGN KEY (annonceur_id) REFERENCES annonceur (id)');
        $this->addSql('CREATE INDEX IDX_AB87FF6BC8764012 ON demande_adoption (annonceur_id)');
    }
}
