<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323104232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make verification_token column nullable';
    }

    public function up(Schema $schema): void
    {
        // Make verification_token column nullable
        $this->addSql('ALTER TABLE user MODIFY verification_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // Revert: make verification_token NOT NULL again
        $this->addSql('ALTER TABLE user MODIFY verification_token VARCHAR(255) NOT NULL');
    }
}
