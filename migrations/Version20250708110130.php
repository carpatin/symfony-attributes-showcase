<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708110130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mainly changes for photo album';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE photo (id SERIAL NOT NULL, filename VARCHAR(255) NOT NULL, content BYTEA NOT NULL, title VARCHAR(20) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))',
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE photo');
    }
}
