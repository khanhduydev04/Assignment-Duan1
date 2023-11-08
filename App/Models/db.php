<?php
class connect
{
  private $conn;

  function pdo_get_connection()
  {
    $dburl = "mysql:host=localhost;dbname=duan;charset=utf8";
    $username = 'root';
    $password = 'mysql';
    $conn = new PDO($dburl, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  }

  // Thêm hàm này để lấy giá trị lastInsertId()
  function lastInsertId()
  {
    return $this->conn->lastInsertId();
  }

  function pdo_execute($sql)
  {
    $sql_args = array_slice(func_get_args(), 1);
    try {
      $conn = $this->pdo_get_connection();
      $stmt = $conn->prepare($sql);
      $stmt->execute($sql_args);
      $lastInsertId = $conn->lastInsertId();
      return [$stmt, $lastInsertId];
    } catch (PDOException $e) {
      throw $e;
    } finally {
      unset($conn);
    }
  }

  function pdo_query($sql)
  {
    $sql_args = array_slice(func_get_args(), 1);
    try {
      $conn = $this->pdo_get_connection();
      $stmt = $conn->prepare($sql);
      $stmt->execute($sql_args);
      $rows = $stmt->fetchAll();
      return $rows;
    } catch (PDOException $e) {
      throw $e;
    } finally {
      unset($conn);
    }
  }
  function pdo_query_one($sql)
  {
    $sql_args = array_slice(func_get_args(), 1);
    try {
      $conn = $this->pdo_get_connection();
      $stmt = $conn->prepare($sql);
      $stmt->execute($sql_args);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row;
    } catch (PDOException $e) {
      throw $e;
    } finally {
      unset($conn);
    }
  }
  function pdo_query_value($sql)
  {
    $sql_args = array_slice(func_get_args(), 1);
    try {
      $conn = $this->pdo_get_connection();
      $stmt = $conn->prepare($sql);
      $stmt->execute($sql_args);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return array_values($row)[0];
    } catch (PDOException $e) {
      throw $e;
    } finally {
      unset($conn);
    }
  }
}
