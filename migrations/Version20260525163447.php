<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260525163447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the user table and required unique indexes';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL,
            username VARCHAR(180) NOT NULL,
            roles JSON NOT NULL,
            password VARCHAR(255) NOT NULL,
            is_active TINYINT(1) NOT NULL,
            email VARCHAR(255) NOT NULL,
            is_verified TINYINT(1) NOT NULL,
            verification_token VARCHAR(255) DEFAULT NULL,
            google_id VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_EMAIL ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_GOOGLE_ID ON user (google_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
