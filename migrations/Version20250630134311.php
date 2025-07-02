<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630134311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change quote author from string to entity reference';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quote DROP author');
        $this->addSql(
            'ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4F675F31B FOREIGN KEY (author_id) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
        $this->addSql('CREATE INDEX IDX_6B71CBF4F675F31B ON quote (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quote DROP CONSTRAINT FK_6B71CBF4F675F31B');
        $this->addSql('DROP INDEX IDX_6B71CBF4F675F31B');
        $this->addSql('ALTER TABLE quote ADD author VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE quote DROP author_id');
    }
}
