<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204152746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE professional ADD updated_at DATETIME DEFAULT NULL, CHANGE uploaded_at uploaded_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE uploaded_at uploaded_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_day CHANGE phone phone VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE business_hour CHANGE professional_id professional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE pack CHANGE uploaded_at uploaded_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE business_hour CHANGE professional_id professional_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category DROP updated_at');
        $this->addSql('ALTER TABLE contact_day CHANGE phone phone VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE image CHANGE uploaded_at uploaded_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE pack CHANGE uploaded_at uploaded_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE professional DROP updated_at, CHANGE uploaded_at uploaded_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE service DROP updated_at');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
