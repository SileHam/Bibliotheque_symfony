<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuteursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authors = [
            'j_k_rowling' => ['name' => 'J.K. Rowling', 'sex' => 'F', 'birthDate' => '1965-07-31', 'country' => 'GB'],
            'j_r_r_tolkien' => ['name' => 'J.R.R. Tolkien', 'sex' => 'M', 'birthDate' => '1892-01-03', 'country' => 'GB'],
            'george_r_r_martin' => ['name' => 'George R.R. Martin', 'sex' => 'M', 'birthDate' => '1948-09-20', 'country' => 'US'],
            'frank_herbert' => ['name' => 'Frank Herbert', 'sex' => 'M', 'birthDate' => '1920-10-08', 'country' => 'US'],
            'harper_lee' => ['name' => 'Harper Lee', 'sex' => 'F', 'birthDate' => '1926-04-28', 'country' => 'US'],
            'george_orwell' => ['name' => 'George Orwell', 'sex' => 'M', 'birthDate' => '1903-06-25', 'country' => 'GB'],
            'paulo_coelho' => ['name' => 'Paulo Coelho', 'sex' => 'M', 'birthDate' => '1947-08-24', 'country' => 'BR'],
            'james_clear' => ['name' => 'James Clear', 'sex' => 'M', 'birthDate' => '1986-01-22', 'country' => 'US'],
            'delia_owens' => ['name' => 'Delia Owens', 'sex' => 'F', 'birthDate' => '1949-04-04', 'country' => 'US'],
            'madeline_miller' => ['name' => 'Madeline Miller', 'sex' => 'F', 'birthDate' => '1978-07-24', 'country' => 'US'],
            'f_scott_fitzgerald' => ['name' => 'F. Scott Fitzgerald', 'sex' => 'M', 'birthDate' => '1896-09-24', 'country' => 'US'],
            'khaled_hosseini' => ['name' => 'Khaled Hosseini', 'sex' => 'M', 'birthDate' => '1965-03-04', 'country' => 'AF'],
        ];

        foreach ($authors as $reference => $data) {
            $auteur = new Auteur();
            $auteur->setNomPrenom($data['name']);
            $auteur->setSexe($data['sex']);
            $auteur->setDateDeNaissance(new \DateTimeImmutable($data['birthDate']));
            $auteur->setNationalite($data['country']);

            $manager->persist($auteur);
            $this->addReference('author_'.$reference, $auteur);
        }

        $manager->flush();
    }
}
