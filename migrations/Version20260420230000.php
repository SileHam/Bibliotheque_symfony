<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260420230000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create catalog baseline tables, enrich books with commerce fields, and add persistent cart items';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('auteur')) {
            $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, sexe VARCHAR(1) NOT NULL, date_de_naissance DATE NOT NULL, nationalite VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_55AB14026EA0B0C (nom_prenom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('genre')) {
            $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_835033F86C6E55B5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        }

        if (!$schema->hasTable('livre')) {
            $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, isbn VARCHAR(13) NOT NULL, titre LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, nombre_pages INT NOT NULL, date_de_parution DATE NOT NULL, note INT NOT NULL, price NUMERIC(10, 2) NOT NULL DEFAULT 0.00, stock INT NOT NULL DEFAULT 0, UNIQUE INDEX UNIQ_AC634F99CC1CF4E6 (isbn), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        } else {
            $livreTable = $schema->getTable('livre');

            if (!$livreTable->hasColumn('description')) {
                $this->addSql('ALTER TABLE livre ADD description LONGTEXT DEFAULT NULL');
            }

            if (!$livreTable->hasColumn('image_url')) {
                $this->addSql('ALTER TABLE livre ADD image_url VARCHAR(255) DEFAULT NULL');
            }

            if (!$livreTable->hasColumn('price')) {
                $this->addSql('ALTER TABLE livre ADD price NUMERIC(10, 2) NOT NULL DEFAULT 0.00');
            }

            if (!$livreTable->hasColumn('stock')) {
                $this->addSql('ALTER TABLE livre ADD stock INT NOT NULL DEFAULT 0');
            }
        }

        if (!$schema->hasTable('livre_auteur')) {
            $this->addSql('CREATE TABLE livre_auteur (livre_id INT NOT NULL, auteur_id INT NOT NULL, INDEX IDX_A11876B537D925CB (livre_id), INDEX IDX_A11876B560BB6FE6 (auteur_id), PRIMARY KEY(livre_id, auteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
            $this->addSql('ALTER TABLE livre_auteur ADD CONSTRAINT FK_A11876B537D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE livre_auteur ADD CONSTRAINT FK_A11876B560BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) ON DELETE CASCADE');
        }

        if (!$schema->hasTable('livre_genre')) {
            $this->addSql('CREATE TABLE livre_genre (livre_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_1053AB9E37D925CB (livre_id), INDEX IDX_1053AB9E4296D31F (genre_id), PRIMARY KEY(livre_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
            $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        }

        if (!$schema->hasTable('cart_item')) {
            $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, livre_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F0FE2527A76ED395 (user_id), INDEX IDX_F0FE252737D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
            $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
            $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE252737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('cart_item')) {
            $this->addSql('DROP TABLE cart_item');
        }

        if ($schema->hasTable('livre_genre')) {
            $this->addSql('DROP TABLE livre_genre');
        }

        if ($schema->hasTable('livre_auteur')) {
            $this->addSql('DROP TABLE livre_auteur');
        }

        if ($schema->hasTable('livre')) {
            $livreTable = $schema->getTable('livre');

            if ($livreTable->hasColumn('description')) {
                $this->addSql('ALTER TABLE livre DROP COLUMN description');
            }

            if ($livreTable->hasColumn('image_url')) {
                $this->addSql('ALTER TABLE livre DROP COLUMN image_url');
            }

            if ($livreTable->hasColumn('price')) {
                $this->addSql('ALTER TABLE livre DROP COLUMN price');
            }

            if ($livreTable->hasColumn('stock')) {
                $this->addSql('ALTER TABLE livre DROP COLUMN stock');
            }
        }
    }
}
