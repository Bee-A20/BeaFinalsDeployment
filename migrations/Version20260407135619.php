<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407135619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE user SET verification_token = UUID() WHERE verification_token IS NULL');
        $this->addSql('ALTER TABLE user CHANGE verification_token verification_token VARCHAR(255) NOT NULL');
        $this->addSql('SET @exists := (SELECT COUNT(*) FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = "user" AND index_name = "uniq_user_google_id");');
        $this->addSql('SET @sql := IF(@exists > 0, "ALTER TABLE user RENAME INDEX uniq_user_google_id TO UNIQ_8D93D64976F5C865", "SELECT \"Index uniq_user_google_id not found\"");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
        
        // Check if stock column exists before adding it
        $this->addSql('SET @exist := (SELECT COUNT(*) FROM information_schema.columns WHERE table_name = "products" AND column_name = "stock" AND table_schema = DATABASE());');
        $this->addSql('SET @sql := IF(@exist = 0, "ALTER TABLE products ADD stock INT DEFAULT NULL", "SELECT \'Column stock already exists\'");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP stock');
        $this->addSql('ALTER TABLE user CHANGE verification_token verification_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('SET @exists := (SELECT COUNT(*) FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = "user" AND index_name = "UNIQ_8D93D64976F5C865");');
        $this->addSql('SET @sql := IF(@exists > 0, "ALTER TABLE user RENAME INDEX UNIQ_8D93D64976F5C865 TO uniq_user_google_id", "SELECT \"Index UNIQ_8D93D64976F5C865 not found\"");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
    }
}
