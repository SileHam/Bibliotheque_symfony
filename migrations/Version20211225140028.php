<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225140028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // Note: ISBN column is already VARCHAR(13) from entity definition, skipping
        if ($schema->hasTable('livre') && $schema->getTable('livre')->hasColumn('isbn')) {
            $column = $schema->getTable('livre')->getColumn('isbn');
            if ($column->getType()->getName() !== 'string' || $column->getLength() !== 13) {
                $this->addSql('ALTER TABLE livre CHANGE isbn isbn VARCHAR(13) NOT NULL');
            }
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // Note: Skipping reverse migration to avoid data loss
    }
}
