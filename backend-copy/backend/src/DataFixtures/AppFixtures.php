<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des auteurs
        $author1 = new Author();
        $author1->setFirstName('Antoine');
        $author1->setLastName('de Saint Exupéry');
        $author1->setCountry('France');
        $manager->persist($author1);

        $author2 = new Author();
        $author2->setFirstName('George');
        $author2->setLastName('Orwell');
        $author2->setCountry('Royaume-Uni');
        $manager->persist($author2);

        $author3 = new Author();
        $author3->setFirstName('Joanne');
        $author3->setLastName('Rowling');
        $author3->setCountry('Royaume-Uni');
        $manager->persist($author3);

        // Création des éditeurs
        $editor1 = new Editor();
        $editor1->setName('Gallimard');
        $editor1->setCreationDate(new \DateTime('1911-05-31'));
        $editor1->setHeadOffice('5 rue Sébastien-Bottin, 75007 Paris, France');
        $manager->persist($editor1);

        $editor2 = new Editor();
        $editor2->setName('Albin Michel');
        $editor2->setCreationDate(new \DateTime('1900-01-01'));
        $editor2->setHeadOffice('22 rue Huyghens, 75014 Paris, France');
        $manager->persist($editor2);

        $editor3 = new Editor();
        $editor3->setName('Flammarion');
        $editor3->setCreationDate(new \DateTime('1875-01-01'));
        $editor3->setHeadOffice('87 quai Panhard et Levassor, 75013 Paris, France');
        $manager->persist($editor3);

        $editor4 = new Editor();
        $editor4->setName('Robert Laffont');
        $editor4->setCreationDate(new \DateTime('1941-01-01'));
        $editor4->setHeadOffice('24 avenue Marceau, 75008 Paris, France');
        $manager->persist($editor4);

        // Création des livres
        $book1 = new Book();
        $book1->setTitle('Le Petit Prince');
        $book1->setDescription('L\'histoire d\'un petit prince qui voyage de planète en planète.');
        $book1->setPages(96);
        $book1->setImage('https://picsum.photos/300/400?random=1');
        $book1->setAuthor($author1);
        $book1->setEditor($editor1); // Gallimard
        $manager->persist($book1);

        $book2 = new Book();
        $book2->setTitle('1984');
        $book2->setDescription('Un roman dystopique sur la surveillance de masse.');
        $book2->setPages(368);
        $book2->setImage('https://picsum.photos/300/400?random=2');
        $book2->setAuthor($author2);
        $book2->setEditor($editor2); // Albin Michel
        $manager->persist($book2);

        $book3 = new Book();
        $book3->setTitle('Harry Potter à l\'école des sorciers');
        $book3->setDescription('Le début des aventures du célèbre sorcier.');
        $book3->setPages(320);
        $book3->setImage('https://picsum.photos/300/400?random=3');
        $book3->setAuthor($author3);
        $book3->setEditor($editor3); // Flammarion
        $manager->persist($book3);

        $manager->flush();
    }
}
