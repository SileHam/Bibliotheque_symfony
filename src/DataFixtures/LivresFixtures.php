<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LivresFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $books = [
            [
                'isbn' => '9780439708180',
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'description' => 'The first year at Hogwarts introduces Harry to friendship, hidden powers, and a magical world that feels both wondrous and dangerous.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780439708180-L.jpg',
                'pages' => 309,
                'publishedAt' => '1998-09-01',
                'note' => 19,
                'price' => 14.90,
                'stock' => 12,
                'authors' => ['author_j_k_rowling'],
                'genres' => ['genre_fantasy', 'genre_young_adult', 'genre_adventure'],
            ],
            [
                'isbn' => '9780261103573',
                'title' => 'The Fellowship of the Ring',
                'description' => 'Frodo begins his journey with the Ring, crossing a vast and ancient world where every choice carries weight.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780261103573-L.jpg',
                'pages' => 423,
                'publishedAt' => '1991-07-04',
                'note' => 19,
                'price' => 15.50,
                'stock' => 9,
                'authors' => ['author_j_r_r_tolkien'],
                'genres' => ['genre_fantasy', 'genre_classic', 'genre_adventure'],
            ],
            [
                'isbn' => '9780553593716',
                'title' => 'A Game of Thrones',
                'description' => 'A brutal political fantasy where noble families, shifting alliances, and looming ancient threats collide.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780553593716-L.jpg',
                'pages' => 835,
                'publishedAt' => '2003-05-27',
                'note' => 18,
                'price' => 16.90,
                'stock' => 7,
                'authors' => ['author_george_r_r_martin'],
                'genres' => ['genre_fantasy', 'genre_adventure'],
            ],
            [
                'isbn' => '9780441172719',
                'title' => 'Dune',
                'description' => 'On Arrakis, a young heir must understand power, prophecy, and survival on the most important planet in the galaxy.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780441172719-L.jpg',
                'pages' => 688,
                'publishedAt' => '1990-09-01',
                'note' => 18,
                'price' => 17.40,
                'stock' => 10,
                'authors' => ['author_frank_herbert'],
                'genres' => ['genre_science_fiction', 'genre_classic', 'genre_adventure'],
            ],
            [
                'isbn' => '9780061120084',
                'title' => 'To Kill a Mockingbird',
                'description' => 'A coming-of-age story about justice, race, and conscience in the American South, told with warmth and clarity.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780061120084-L.jpg',
                'pages' => 336,
                'publishedAt' => '2006-05-23',
                'note' => 18,
                'price' => 13.90,
                'stock' => 11,
                'authors' => ['author_harper_lee'],
                'genres' => ['genre_classic', 'genre_literary_fiction', 'genre_historical_fiction'],
            ],
            [
                'isbn' => '9780451524935',
                'title' => '1984',
                'description' => 'A chilling dystopia about surveillance, propaganda, and the destruction of private thought.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg',
                'pages' => 328,
                'publishedAt' => '1950-07-01',
                'note' => 17,
                'price' => 12.50,
                'stock' => 14,
                'authors' => ['author_george_orwell'],
                'genres' => ['genre_classic', 'genre_science_fiction'],
            ],
            [
                'isbn' => '9780062315007',
                'title' => 'The Alchemist',
                'description' => 'A philosophical fable about purpose, intuition, and following the path that feels meant for you.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780062315007-L.jpg',
                'pages' => 208,
                'publishedAt' => '2014-04-15',
                'note' => 16,
                'price' => 11.80,
                'stock' => 15,
                'authors' => ['author_paulo_coelho'],
                'genres' => ['genre_classic', 'genre_adventure'],
            ],
            [
                'isbn' => '9780735211292',
                'title' => 'Atomic Habits',
                'description' => 'A practical framework for building better habits through small systems that compound over time.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780735211292-L.jpg',
                'pages' => 320,
                'publishedAt' => '2018-10-16',
                'note' => 18,
                'price' => 18.20,
                'stock' => 20,
                'authors' => ['author_james_clear'],
                'genres' => ['genre_personal_development'],
            ],
            [
                'isbn' => '9780735219090',
                'title' => 'Where the Crawdads Sing',
                'description' => 'A lyrical mystery rooted in isolation, resilience, and the marshlands of North Carolina.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780735219090-L.jpg',
                'pages' => 384,
                'publishedAt' => '2018-08-14',
                'note' => 17,
                'price' => 15.20,
                'stock' => 8,
                'authors' => ['author_delia_owens'],
                'genres' => ['genre_mystery', 'genre_literary_fiction'],
            ],
            [
                'isbn' => '9780316556347',
                'title' => 'Circe',
                'description' => 'A modern retelling of Greek myth centered on exile, transformation, and the making of a formidable witch.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780316556347-L.jpg',
                'pages' => 393,
                'publishedAt' => '2019-04-09',
                'note' => 18,
                'price' => 16.10,
                'stock' => 13,
                'authors' => ['author_madeline_miller'],
                'genres' => ['genre_mythology', 'genre_historical_fiction', 'genre_literary_fiction'],
            ],
            [
                'isbn' => '9780743273565',
                'title' => 'The Great Gatsby',
                'description' => 'A sharp portrait of ambition, desire, and illusion in the Jazz Age.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9780743273565-L.jpg',
                'pages' => 180,
                'publishedAt' => '2004-09-30',
                'note' => 16,
                'price' => 10.90,
                'stock' => 16,
                'authors' => ['author_f_scott_fitzgerald'],
                'genres' => ['genre_classic', 'genre_literary_fiction'],
            ],
            [
                'isbn' => '9781594631931',
                'title' => 'The Kite Runner',
                'description' => 'A moving story of guilt, loyalty, and redemption spanning Kabul and the immigrant experience.',
                'imageUrl' => 'https://covers.openlibrary.org/b/isbn/9781594631931-L.jpg',
                'pages' => 372,
                'publishedAt' => '2013-03-05',
                'note' => 18,
                'price' => 14.60,
                'stock' => 9,
                'authors' => ['author_khaled_hosseini'],
                'genres' => ['genre_historical_fiction', 'genre_literary_fiction'],
            ],
        ];

        foreach ($books as $data) {
            $book = new Livre();
            $book
                ->setIsbn($data['isbn'])
                ->setTitre($data['title'])
                ->setDescription($data['description'])
                ->setImageUrl($data['imageUrl'])
                ->setNombrePages($data['pages'])
                ->setDateDeParution(new \DateTimeImmutable($data['publishedAt']))
                ->setNote($data['note'])
                ->setPrice($data['price'])
                ->setStock($data['stock']);

            foreach ($data['authors'] as $authorReference) {
                $book->addAuteur($this->getReference($authorReference, Auteur::class));
            }

            foreach ($data['genres'] as $genreReference) {
                $book->addGenre($this->getReference($genreReference, Genre::class));
            }

            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuteursFixtures::class,
            GenreFixtures::class,
        ];
    }
}
