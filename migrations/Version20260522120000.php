<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260522120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add nullable image column to products table for shop product display.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('SET @exist := (SELECT COUNT(*) FROM information_schema.columns WHERE table_name = "products" AND column_name = "image" AND table_schema = DATABASE());');
        $this->addSql('SET @sql := IF(@exist = 0, "ALTER TABLE products ADD image VARCHAR(255) DEFAULT NULL", "SELECT \"Column image already exists\"");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products DROP image');
    }
}
