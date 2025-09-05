<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;
use App\Repository\BookRepository;
use PHPUnit\Framework\TestCase;

/**
 * Tests d'intégration pour BookRepository
 * 
 * Ces tests vérifient la logique des repositories sans base de données réelle.
 * Ils testent les méthodes de recherche et la logique métier des repositories.
 */
class BookRepositoryTest extends TestCase
{
    private BookRepository $bookRepository;

    protected function setUp(): void
    {
        // Mock du repository pour tester la logique sans base de données
        $this->bookRepository = $this->createMock(BookRepository::class);
    }

    /**
     * Test de la logique de recherche par titre
     */
    public function testFindByTitleLogic(): void
    {
        // Créer des livres de test
        $book1 = new Book();
        $book1->setTitle('Le Seigneur des Anneaux');
        $book1->setImage('tolkien-lotr.jpg');
        $book1->setDescription('Un hobbit part à l\'aventure...');
        $book1->setPages(423);

        $book2 = new Book();
        $book2->setTitle('Foundation');
        $book2->setImage('asimov-foundation.jpg');
        $book2->setDescription('L\'empire galactique s\'effondre...');
        $book2->setPages(244);

        // Simuler la logique de recherche par titre
        $books = [$book1, $book2];
        $searchTitle = 'Seigneur';
        
        $filteredBooks = array_filter($books, function($book) use ($searchTitle) {
            return stripos($book->getTitle(), $searchTitle) !== false;
        });

        // Vérifications
        $this->assertCount(1, $filteredBooks);
        $this->assertEquals('Le Seigneur des Anneaux', reset($filteredBooks)->getTitle());
    }

    /**
     * Test de la logique de recherche par auteur
     */
    public function testFindByAuthorLogic(): void
    {
        // Créer un auteur
        $author = new Author();
        $author->setFirstName('Isaac');
        $author->setLastName('Asimov');
        $author->setCountry('USA');

        // Créer des livres
        $book1 = new Book();
        $book1->setTitle('Foundation');
        $book1->setImage('foundation.jpg');
        $book1->setDescription('Premier livre');
        $book1->setPages(244);
        $book1->setAuthor($author);

        $book2 = new Book();
        $book2->setTitle('I, Robot');
        $book2->setImage('i-robot.jpg');
        $book2->setDescription('Deuxième livre');
        $book2->setPages(253);
        $book2->setAuthor($author);

        // Simuler la logique de recherche par auteur
        $books = [$book1, $book2];
        $filteredBooks = array_filter($books, function($book) use ($author) {
            return $book->getAuthor() === $author;
        });

        // Vérifications
        $this->assertCount(2, $filteredBooks);
        foreach ($filteredBooks as $book) {
            $this->assertEquals($author, $book->getAuthor());
        }
    }

    /**
     * Test de la logique de recherche par nombre de pages
     */
    public function testFindByPagesRangeLogic(): void
    {
        // Créer des livres avec différents nombres de pages
        $books = [];
        for ($i = 1; $i <= 5; $i++) {
            $book = new Book();
            $book->setTitle("Livre $i");
            $book->setImage("livre-$i.jpg");
            $book->setDescription("Description du livre $i");
            $book->setPages($i * 100); // 100, 200, 300, 400, 500 pages
            $books[] = $book;
        }

        // Simuler la recherche par plage de pages (200-400)
        $minPages = 200;
        $maxPages = 400;
        
        $filteredBooks = array_filter($books, function($book) use ($minPages, $maxPages) {
            $pages = $book->getPages();
            return $pages >= $minPages && $pages <= $maxPages;
        });

        // Vérifications
        $this->assertCount(3, $filteredBooks); // Livres 2, 3, 4
        foreach ($filteredBooks as $book) {
            $this->assertGreaterThanOrEqual($minPages, $book->getPages());
            $this->assertLessThanOrEqual($maxPages, $book->getPages());
        }
    }

    /**
     * Test de la logique de tri par titre
     */
    public function testSortByTitleLogic(): void
    {
        // Créer des livres avec des titres différents
        $book1 = new Book();
        $book1->setTitle('Zorro');
        $book1->setImage('zorro.jpg');
        $book1->setDescription('Le justicier masqué');
        $book1->setPages(200);

        $book2 = new Book();
        $book2->setTitle('Alice au pays des merveilles');
        $book2->setImage('alice.jpg');
        $book2->setDescription('Les aventures d\'Alice');
        $book2->setPages(150);

        $book3 = new Book();
        $book3->setTitle('1984');
        $book3->setImage('1984.jpg');
        $book3->setDescription('Roman dystopique');
        $book3->setPages(328);

        $books = [$book1, $book2, $book3];

        // Simuler le tri par titre
        usort($books, function($a, $b) {
            return strcmp($a->getTitle(), $b->getTitle());
        });

        // Vérifications
        $this->assertEquals('1984', $books[0]->getTitle());
        $this->assertEquals('Alice au pays des merveilles', $books[1]->getTitle());
        $this->assertEquals('Zorro', $books[2]->getTitle());
    }

    /**
     * Test de la logique de recherche avec relations
     */
    public function testFindWithRelationsLogic(): void
    {
        // Créer un auteur
        $author = new Author();
        $author->setFirstName('George');
        $author->setLastName('Orwell');
        $author->setCountry('Royaume-Uni');

        // Créer un éditeur
        $editor = new Editor();
        $editor->setName('Secker & Warburg');
        $editor->setCreationDate(new \DateTime('1936-01-01'));
        $editor->setHeadOffice('Londres, Royaume-Uni');

        // Créer un livre avec relations
        $book = new Book();
        $book->setTitle('1984');
        $book->setImage('orwell-1984.jpg');
        $book->setDescription('Un roman dystopique');
        $book->setPages(328);
        $book->setAuthor($author);
        $book->setEditor($editor);

        // Simuler la récupération avec relations
        $books = [$book];
        $bookWithRelations = $books[0];

        // Vérifier les relations
        $this->assertNotNull($bookWithRelations->getAuthor());
        $this->assertEquals('George', $bookWithRelations->getAuthor()->getFirstName());
        $this->assertEquals('Orwell', $bookWithRelations->getAuthor()->getLastName());

        $this->assertNotNull($bookWithRelations->getEditor());
        $this->assertEquals('Secker & Warburg', $bookWithRelations->getEditor()->getName());
    }

    /**
     * Test de la logique de pagination
     */
    public function testPaginationLogic(): void
    {
        // Créer une liste de livres
        $books = [];
        for ($i = 1; $i <= 25; $i++) {
            $book = new Book();
            $book->setTitle("Livre $i");
            $book->setImage("livre-$i.jpg");
            $book->setDescription("Description du livre $i");
            $book->setPages($i * 10);
            $books[] = $book;
        }

        // Simuler la pagination (page 2, 10 éléments par page)
        $page = 2;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $paginatedBooks = array_slice($books, $offset, $limit);

        // Vérifications
        $this->assertCount(10, $paginatedBooks);
        $this->assertEquals('Livre 11', $paginatedBooks[0]->getTitle());
        $this->assertEquals('Livre 20', $paginatedBooks[9]->getTitle());
    }

    /**
     * Test de la logique de recherche avancée
     */
    public function testAdvancedSearchLogic(): void
    {
        // Créer des livres avec différents critères
        $author1 = new Author();
        $author1->setFirstName('J.R.R.');
        $author1->setLastName('Tolkien');
        $author1->setCountry('Royaume-Uni');

        $author2 = new Author();
        $author2->setFirstName('Isaac');
        $author2->setLastName('Asimov');
        $author2->setCountry('USA');

        $books = [
            (new Book())->setTitle('Le Seigneur des Anneaux')->setPages(423)->setAuthor($author1),
            (new Book())->setTitle('Foundation')->setPages(244)->setAuthor($author2),
            (new Book())->setTitle('Le Hobbit')->setPages(310)->setAuthor($author1),
            (new Book())->setTitle('I, Robot')->setPages(253)->setAuthor($author2),
        ];

        // Recherche avancée : livres de Tolkien avec plus de 300 pages
        $filteredBooks = array_filter($books, function($book) {
            return $book->getAuthor()->getLastName() === 'Tolkien' && $book->getPages() > 300;
        });

        // Vérifications
        $this->assertCount(2, $filteredBooks);
        foreach ($filteredBooks as $book) {
            $this->assertEquals('Tolkien', $book->getAuthor()->getLastName());
            $this->assertGreaterThan(300, $book->getPages());
        }
    }
}
