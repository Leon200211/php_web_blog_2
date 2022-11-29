<?php


namespace Blog\Test\Unit;

use Blog\Database;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Twig\Node\MacroNode;


// тестируем класс Database
class DatabaseTest extends TestCase
{
    private Database $object;

    private MockObject $connection;
    protected function setUp() : void {
        $this->connection = $this->createMock(PDO::class);
        $this->object = new Database($this->connection);
    }


    public function testGetConnection() : void  {
        $result = $this->object->getConnection();
        $this->assertInstanceOf(PDO::class, $result);
    }

}