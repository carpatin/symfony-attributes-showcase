<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250702103904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates pet table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE pet (id SERIAL NOT NULL, name VARCHAR(50) NOT NULL, is_thirsty BOOLEAN DEFAULT false NOT NULL, is_hungry BOOLEAN DEFAULT false NOT NULL, mood VARCHAR(255) DEFAULT \'relaxed\' NOT NULL, PRIMARY KEY(id))',
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4529B855E237E06 ON pet (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pet');
    }
}
