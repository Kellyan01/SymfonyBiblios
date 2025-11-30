<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Editor;
use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Comment;
use App\Enum\CommentStatus;
use App\Enum\BookStatus;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //SANS FAKER A LA MAIN
        // $book = new Book();
        // $book->setTitle("The Great Gatsby")
        //     ->setIsbn("9780743273565")
        //     ->setCover("great_gatsby.jpg")
        //     ->setEditedAt(new \DateTimeImmutable('1925-04-10'))
        //     ->setPlot("A novel about the American dream.")
        //     ->setPageNumber(180)
        //     ->setStatus(BookStatus::Available)
        //     ->setEditor($editor);
        // $author = new Author();
        // $author->setName("F. Scott")
        //     ->setDateOfBirth(new \DateTimeImmutable('1896-09-24'))
        //     ->setNationality("American")
        //     ->addBook($book );
        // // $manager->persist($product);
        // $manager->persist($editor);
        // $manager->persist($book);
        // $manager->persist($author);

        // AVEC FAKER
        $faker = Faker\Factory::create("fr_FR");

        // Création de 10 éditeurs avec Faker
        //tableau editeurs
        $editors = [];
        for ($i = 0; $i < 10; $i++) {
            $editor = new Editor($faker->company());
            // Persister chaque éditeur dans la base de données
            $manager->persist($editor);
            $editors[] = $editor;
        }
        // Création de 50 livres avec Faker
        $books = [];
        for ($i = 0; $i < 50; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence(3))
                ->setIsbn($faker->isbn13())
                ->setCover($faker->imageUrl(200, 300, 'books', true))
                ->setEditedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-10 years', 'now')))
                ->setPlot($faker->paragraph())
                ->setPageNumber($faker->numberBetween(100, 1000))
                ->setStatus($faker->randomElement([BookStatus::Available, BookStatus::Borrowed, BookStatus::Unavailable]))
                ->setEditor($faker->randomElement($editors));
            // Persister chaque livre dans la base de données
            $manager->persist($book);
            $books[] = $book;
        }
        // Création de 30 auteurs avec Faker
        $authors = [];
        for ($i = 0; $i < 30; $i++) {
            $author = new Author();
            $author->setName($faker->name())
                ->setDateOfBirth(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-80 years', '-20 years')))
                ->setNationality($faker->country());
            // Associer chaque auteur à 1 à 3 livres aléatoires
            $numBooks = $faker->numberBetween(1, 3);
            $authorBooks = $faker->randomElements($books, $numBooks);
            foreach ($authorBooks as $book) {
                $author->addBook($book);
            }
            // Persister chaque auteur dans la base de données
            $manager->persist($author);
            $authors[] = $author;
        }

        $manager->flush();
    }
}
