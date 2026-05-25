<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260521085528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, note VARCHAR(255) DEFAULT NULL, product_id INT NOT NULL, created_by_id INT DEFAULT NULL, INDEX IDX_4B3656604584665A (product_id), INDEX IDX_4B365660B03A8386 (created_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('SET @sql := IF((SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = "products") = 1, "ALTER TABLE stock ADD CONSTRAINT FK_4B3656604584665A FOREIGN KEY (product_id) REFERENCES products (id)", "SELECT \'No-op: products table missing\'");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('SET @sql := IF((SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = "products") = 1 AND (SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = "products" AND column_name = "stock") = 1, "ALTER TABLE products DROP stock", "SELECT \'No-op: products table or column missing\'");');
        $this->addSql('PREPARE stmt FROM @sql;');
        $this->addSql('EXECUTE stmt;');
        $this->addSql('DEALLOCATE PREPARE stmt;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656604584665A');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660B03A8386');
        $this->addSql('DROP TABLE stock');
        $this->addSql('ALTER TABLE products ADD stock INT DEFAULT NULL');
    }
}
