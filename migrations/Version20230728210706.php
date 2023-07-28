<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230728210706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish DROP CONSTRAINT fk_d7d174c99d86650f');
        $this->addSql('DROP INDEX idx_d7d174c99d86650f');
        $this->addSql('ALTER TABLE wish RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT FK_D7D174C9A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D7D174C9A76ED395 ON wish (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE wish DROP CONSTRAINT FK_D7D174C9A76ED395');
        $this->addSql('DROP INDEX IDX_D7D174C9A76ED395');
        $this->addSql('ALTER TABLE wish RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT fk_d7d174c99d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d7d174c99d86650f ON wish (user_id_id)');
    }
}
