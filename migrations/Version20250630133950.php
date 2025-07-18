<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630133950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the author table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE author (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, year_born SMALLINT, year_died SMALLINT, PRIMARY KEY(id))',
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE author');
    }
}
