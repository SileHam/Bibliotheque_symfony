<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417224000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user activity history table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_activity (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, action VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_853A4A0DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_853A4A0DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user_activity');
    }
}
