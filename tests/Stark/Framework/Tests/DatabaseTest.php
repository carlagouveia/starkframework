<?php

namespace Stark\Framework\Tests;

use Stark\Framework\Database\Manager;
use Stark\Framework\Database\Connection;

class DatabaseTest extends \PHPUnit_Framework_Testcase
{
    public static $driver = 'mysql';
    public static $host = 'localhost';
    public static $dbname = 'stark_test_db';
    public static $user = 'root';
    public static $password = '';
    protected $db;

    public static function setUpBeforeClass()
    {
        $db = new Connection(self::$driver, self::$host, '', self::$user, self::$password);
        $db->getConnection()->exec('CREATE DATABASE IF NOT EXISTS ' . self::$dbname);
        $db->getConnection()->exec('USE ' . self::$dbname);
        $db->getConnection()->exec("CREATE TABLE fixtures (id INT AUTO_INCREMENT PRIMARY KEY, title text, date int)");
        $db->getConnection()->exec("INSERT INTO fixtures (title, date) VALUES ('tche', 123456789)");
    }

    public function setUp()
    {
        $connection = new Connection(self::$driver, self::$host, self::$dbname, self::$user, self::$password);
        $this->db = new Manager($connection);
    }

    public function testIsSelectingData()
    {
        $results = $this->db->findAll('fixtures');
        $this->assertEquals('tche', $results[0]['title']);
        $this->assertEquals('123456789', $results[0]['date']);

        $results = $this->db->findAll('fixtures', array('title'));
        $this->assertEquals('tche', $results[0]['title']);
        $this->assertFalse(isset($results[0]['date']));
    }

    public function testIsSelectingSingleData()
    {
        $results = $this->db->find('fixtures', 1);
        $this->assertEquals('tche', $results['title']);
        $this->assertEquals('123456789', $results['date']);

        $results = $this->db->find('fixtures', 1, array('title'));
        $this->assertEquals('tche', $results['title']);
        $this->assertFalse(isset($results['date']));
    }

    public function testIsInsertingData()
    {
        $this->db->create('fixtures', array('title' => 'My test', 'date' => 666));

        $results = $this->db->findAll('fixtures');
        $this->assertEquals('My test', $results[1]['title']);
        $this->assertEquals('666', $results[1]['date']);
    }

    public function testIsUpdatingData()
    {
        $this->db->update('fixtures', 2, array('title' => 'Another test', 'date' => 777));

        $results = $this->db->findAll('fixtures');
        $this->assertEquals('Another test', $results[1]['title']);
        $this->assertEquals('777', $results[1]['date']);
    }

    public function testIsDeletingData()
    {
        $this->db->delete('fixtures', 2);

        $results = $this->db->findAll('fixtures');
        $this->assertEquals(1, count($results));
    }

    public function testIsExecutingCommand()
    {
        $this->db->exec("INSERT INTO fixtures (title, date) VALUES ('Exec', 555)");

        $results = $this->db->findAll('fixtures');
        $this->assertEquals('Exec', $results[1]['title']);
        $this->assertEquals('555', $results[1]['date']);
    }

    public function testIsQuerying()
    {
        $results = $this->db->query("DESC fixtures");
        $this->assertEquals(3, count($results));
        $this->assertEquals('id', $results[0]['Field']);
        $this->assertEquals('title', $results[1]['Field']);
        $this->assertEquals('date', $results[2]['Field']);
    }

    public static function tearDownAfterClass()
    {
        $db = new Connection(self::$driver, self::$host, self::$dbname, self::$user, self::$password);
        $db->getConnection()->exec('DROP DATABASE ' . self::$dbname);
    }
}