<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417224500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Normalize user_activity foreign-key index naming';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_activity DROP FOREIGN KEY FK_853A4A0DA76ED395');
        $this->addSql('DROP INDEX IDX_853A4A0DA76ED395 ON user_activity');
        $this->addSql('CREATE INDEX IDX_4CF9ED5AA76ED395 ON user_activity (user_id)');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_853A4A0DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_activity DROP FOREIGN KEY FK_853A4A0DA76ED395');
        $this->addSql('DROP INDEX IDX_4CF9ED5AA76ED395 ON user_activity');
        $this->addSql('CREATE INDEX IDX_853A4A0DA76ED395 ON user_activity (user_id)');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_853A4A0DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
