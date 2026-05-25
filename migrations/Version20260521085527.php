<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260521085527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create products table for shop functionality.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, description VARCHAR(255) DEFAULT NULL, stock INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_by_id INT DEFAULT NULL, INDEX IDX_5B5B6FC2F675F31B (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_5B5B6FC2F675F31B FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_5B5B6FC2F675F31B');
        $this->addSql('DROP TABLE products');
    }
}
