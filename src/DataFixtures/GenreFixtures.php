<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = [
            'fantasy' => 'Fantasy',
            'young_adult' => 'Young Adult',
            'adventure' => 'Adventure',
            'science_fiction' => 'Science Fiction',
            'classic' => 'Classic',
            'literary_fiction' => 'Literary Fiction',
            'historical_fiction' => 'Historical Fiction',
            'personal_development' => 'Personal Development',
            'mystery' => 'Mystery',
            'mythology' => 'Mythology',
        ];

        foreach ($genres as $reference => $name) {
            $genre = new Genre();
            $genre->setNom($name);

            $manager->persist($genre);
            $this->addReference('genre_'.$reference, $genre);
        }

        $manager->flush();
    }
}
