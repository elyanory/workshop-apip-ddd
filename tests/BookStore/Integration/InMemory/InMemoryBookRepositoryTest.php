<?php

declare(strict_types=1);

namespace App\Tests\BookStore\Integration\InMemory;

use App\BookStore\Infrastructure\InMemory\InMemoryBookRepository;
use App\Tests\BookStore\DummyFactory\DummyBookFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class InMemoryBookRepositoryTest extends KernelTestCase
{
    protected function setUp(): void
    {
        static::bootKernel();
    }

    public function testAdd(): void
    {
        /** @var InMemoryBookRepository $repository */
        $repository = static::getContainer()->get(InMemoryBookRepository::class);

        static::assertEmpty($repository);

        $book = DummyBookFactory::createBook();
        $repository->add($book);

        static::assertCount(1, $repository);
    }

    public function testRemove(): void
    {
        /** @var InMemoryBookRepository $repository */
        $repository = static::getContainer()->get(InMemoryBookRepository::class);

        $book = DummyBookFactory::createBook();
        $repository->add($book);

        static::assertCount(1, $repository);

        $repository->remove($book);
        static::assertEmpty($repository);
    }

    public function testOfId(): void
    {
        /** @var InMemoryBookRepository $repository */
        $repository = static::getContainer()->get(InMemoryBookRepository::class);

        static::assertEmpty($repository);

        $book = DummyBookFactory::createBook();
        $repository->add($book);

        static::assertSame($book, $repository->ofId($book->id));
    }

    public function testIterator(): void
    {
        /** @var InMemoryBookRepository $repository */
        $repository = static::getContainer()->get(InMemoryBookRepository::class);

        $books = [
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
        ];
        foreach ($books as $book) {
            $repository->add($book);
        }

        $i = 0;
        foreach ($repository as $book) {
            static::assertSame($books[$i], $book);
            ++$i;
        }
    }

    public function testCount(): void
    {
        /** @var InMemoryBookRepository $repository */
        $repository = static::getContainer()->get(InMemoryBookRepository::class);

        $books = [
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
            DummyBookFactory::createBook(),
        ];
        foreach ($books as $book) {
            $repository->add($book);
        }

        static::assertCount(count($books), $repository);
    }
}
