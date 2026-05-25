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
        // Index rename intentionally skipped: ensure migrations do not fail if index absent
        
        // Only add `stock` if the `products` table exists and the column is missing
        $this->addSql('SET @sql := IF((SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = "products") = 1 AND (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = "products" AND column_name = "stock") = 0, "ALTER TABLE products ADD stock INT DEFAULT NULL", "SELECT \'No-op: products table missing or column exists\'");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // Only drop `stock` if the `products` table exists and the column exists
        $this->addSql('SET @sql := IF((SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = "products") = 1 AND (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = "products" AND column_name = "stock") = 1, "ALTER TABLE products DROP stock", "SELECT \'No-op: products table or column missing\'");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
        $this->addSql('ALTER TABLE user CHANGE verification_token verification_token VARCHAR(255) DEFAULT NULL');
        // Index rename intentionally skipped in down(): no-op to avoid errors
    }
}
