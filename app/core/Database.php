<?php
/**
 * Database Class
 * Handles database connection using PDO with singleton pattern
 */

class Database
{
  private static $instance = null;
  private $connection;

  /**
   * Private constructor to prevent direct instantiation
   */
  private function __construct()
  {
    try {
      $this->connection = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
      );

      // Set error mode to exceptions
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Set default fetch mode to associative array
      $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      die("Database Connection Failed: " . $e->getMessage());
    }
  }

  /**
   * Get singleton instance of Database
   * @return Database
   */
  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  /**
   * Get PDO connection object
   * @return PDO
   */
  public function getConnection()
  {
    return $this->connection;
  }

  /**
   * Prevent cloning of the instance
   */
  private function __clone()
  {
  }

  /**
   * Prevent unserializing of the instance
   */
  public function __wakeup()
  {
    throw new Exception("Cannot unserialize singleton");
  }
}