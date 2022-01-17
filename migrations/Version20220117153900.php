<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117153900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vin ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vin ADD CONSTRAINT FK_B108514198260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_B108514198260155 ON vin (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vin DROP FOREIGN KEY FK_B108514198260155');
        $this->addSql('DROP INDEX IDX_B108514198260155 ON vin');
        $this->addSql('ALTER TABLE vin DROP region_id');
    }
}
