<?php

namespace traits;

use PDO;

trait find {
  protected function find($procedure, $params = []) {
    $error = $this->exec_proc(
      $procedure,
      $params,
      PDO::FETCH_ASSOC,
      false
    );

    if ($error['КодОшибки']) return $error;

    $this->query->nextRowset();
    return $this->query->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function findOne($procedure, $params = []) {
    $result = $this->find($procedure, $params);
    return $result[0];
  }
}
