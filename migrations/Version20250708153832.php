<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708153832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Updated photo table to include uploader';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo ADD uploader_id INT NOT NULL');
        $this->addSql(
            'ALTER TABLE photo ADD CONSTRAINT FK_14B7841816678C77 FOREIGN KEY (uploader_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE',
        );
        $this->addSql('CREATE INDEX IDX_14B7841816678C77 ON photo (uploader_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP CONSTRAINT FK_14B7841816678C77');
        $this->addSql('DROP INDEX IDX_14B7841816678C77');
        $this->addSql('ALTER TABLE photo DROP uploader_id');
    }
}
