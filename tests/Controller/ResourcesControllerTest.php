<?php
namespace App\Tests\Controller;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

/**
 *
 */
class ResourcesControllerTest extends TestCase
{
    /**
     * @var PDO
     */
    private PDO $pdo;
    /**
     * @var string|false
     */
    private string|false $resourceId;

    /**
     * @return void
     */
    protected function setUp(): void {
        $dsn = 'mysql:host=127.0.0.1;dbname=infogouv;charset=utf8mb4';
        $username = 'root';
        $password = '';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }

        $sql = 'INSERT INTO resources (title, content) VALUES (:title, :content)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['title' => 'Titre', 'content' => 'Contenu de ma page']);
        $this->resourceId = $this->pdo->lastInsertId();
    }

    /**
     * @return void
     */
    protected function tearDown(): void {
        $sql = 'DELETE FROM resources WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $this->resourceId]);
    }

    /**
     * @return void
     */
    public function testResources() {
        $sql = 'SELECT title, content FROM resources WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $this->resourceId]);
        $resourceFromDb = $stmt->fetch();
        assertEquals('Titre', $resourceFromDb['title']);
        assertEquals('Contenu de ma page', $resourceFromDb['content']);
    }
}