<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200203130957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, name VARCHAR(150) NOT NULL, slug VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, professional_id INT NOT NULL, service_id INT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, hour VARCHAR(10) NOT NULL, hour_end VARCHAR(10) NOT NULL, INDEX IDX_E00CEDDEDB77003 (professional_id), INDEX IDX_E00CEDDEED5CA9E6 (service_id), INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dashboard (id INT AUTO_INCREMENT NOT NULL, category INT NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, professional_id INT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(50) NOT NULL, slogan LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, duration INT NOT NULL, service_type INT NOT NULL, price INT NOT NULL, filename VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD212469DE2 (category_id), INDEX IDX_E19D9AD2DB77003 (professional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE business_hour (id INT AUTO_INCREMENT NOT NULL, professional_id INT DEFAULT NULL, day INT NOT NULL, open_time TIME NOT NULL, close_time TIME NOT NULL, INDEX IDX_20851343DB77003 (professional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(100) NOT NULL, birthdate DATETIME NOT NULL, phone VARCHAR(10) NOT NULL, adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, is_validated TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, is_home_page TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, is_home_page TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_verify (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C477317EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, price INT NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, uploaded_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, professional_id INT NOT NULL, slug VARCHAR(50) NOT NULL, title VARCHAR(100) NOT NULL, content LONGTEXT NOT NULL, is_home_page TINYINT(1) NOT NULL, INDEX IDX_23A0E66DB77003 (professional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professional (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, phone VARCHAR(10) NOT NULL, uploaded_at DATETIME DEFAULT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, uploaded_at DATETIME DEFAULT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_prices (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_DA0C686FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEDB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE business_hour ADD CONSTRAINT FK_20851343DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE user_verify ADD CONSTRAINT FK_C477317EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66DB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE service_prices ADD CONSTRAINT FK_DA0C686FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD212469DE2');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEED5CA9E6');
        $this->addSql('ALTER TABLE service_prices DROP FOREIGN KEY FK_DA0C686FED5CA9E6');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE user_verify DROP FOREIGN KEY FK_C477317EA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEDB77003');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2DB77003');
        $this->addSql('ALTER TABLE business_hour DROP FOREIGN KEY FK_20851343DB77003');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66DB77003');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE dashboard');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE contact_day');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE business_hour');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE information');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE user_verify');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE professional');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE service_prices');
    }
}
