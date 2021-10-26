<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025131316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande_adoption_chien (demande_adoption_id INT NOT NULL, chien_id INT NOT NULL, INDEX IDX_9468EEF4C23B0AAB (demande_adoption_id), INDEX IDX_9468EEF4BFCF400E (chien_id), PRIMARY KEY(demande_adoption_id, chien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_adoption_chien ADD CONSTRAINT FK_9468EEF4C23B0AAB FOREIGN KEY (demande_adoption_id) REFERENCES demande_adoption (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demande_adoption_chien ADD CONSTRAINT FK_9468EEF4BFCF400E FOREIGN KEY (chien_id) REFERENCES chien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_C7440455A73F0036 ON client (ville_id)');
        $this->addSql('ALTER TABLE demande_adoption ADD client_id INT DEFAULT NULL, ADD annonceur_id INT NOT NULL, ADD annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6BC8764012 FOREIGN KEY (annonceur_id) REFERENCES annonceur (id)');
        $this->addSql('ALTER TABLE demande_adoption ADD CONSTRAINT FK_AB87FF6B8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_AB87FF6B19EB6921 ON demande_adoption (client_id)');
        $this->addSql('CREATE INDEX IDX_AB87FF6BC8764012 ON demande_adoption (annonceur_id)');
        $this->addSql('CREATE INDEX IDX_AB87FF6B8805AB2F ON demande_adoption (annonce_id)');
        $this->addSql('ALTER TABLE message ADD client_id INT NOT NULL, ADD demande_adoption_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FC23B0AAB FOREIGN KEY (demande_adoption_id) REFERENCES demande_adoption (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F19EB6921 ON message (client_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FC23B0AAB ON message (demande_adoption_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE demande_adoption_chien');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A73F0036');
        $this->addSql('DROP INDEX IDX_C7440455A73F0036 ON client');
        $this->addSql('ALTER TABLE client DROP ville_id');
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6B19EB6921');
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6BC8764012');
        $this->addSql('ALTER TABLE demande_adoption DROP FOREIGN KEY FK_AB87FF6B8805AB2F');
        $this->addSql('DROP INDEX IDX_AB87FF6B19EB6921 ON demande_adoption');
        $this->addSql('DROP INDEX IDX_AB87FF6BC8764012 ON demande_adoption');
        $this->addSql('DROP INDEX IDX_AB87FF6B8805AB2F ON demande_adoption');
        $this->addSql('ALTER TABLE demande_adoption DROP client_id, DROP annonceur_id, DROP annonce_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F19EB6921');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FC23B0AAB');
        $this->addSql('DROP INDEX IDX_B6BD307F19EB6921 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FC23B0AAB ON message');
        $this->addSql('ALTER TABLE message DROP client_id, DROP demande_adoption_id');
    }
}
