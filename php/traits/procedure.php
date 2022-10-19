<?php

namespace traits;

use PDO;

trait procedure {
  public function exec_proc ($procedure, $parameters = [], $fetch = PDO::FETCH_ASSOC, $all = true) {
    try {
      if (preg_match('~^SELECT ~i', $procedure)) {
        $query_text = $procedure . '(';
        $i = 0;

        foreach ($parameters as $key => $value) {
          $k = $this->str2url($key);
          $query_text .= ":{$k},";
          $i++;
        }

        if ($i > 0) $query_text = substr($query_text, 0, -1) . ')';
        else $query_text = $query_text . ')';
      }else {
        $query_text = "EXEC $procedure ";

        foreach ($parameters as $key => $value) {
          $query_text .= "@{$key}= '{$value}',";
        }

        $query_text = substr($query_text, 0, -1);
      }

      $this->query = $this->db->prepare($query_text);
      $atributes = $this->rules();

      foreach ($atributes as $key => $value) {
        try {
          if (is_array($value)) {
            if (is_multi_array($value)) {
              for ($i = 0; $i < count($value[0]); $i++) {
                $this->validate($value[0][$i], $parameters, $value[1]);
              }
            }else {
              $this->validate($value[0], $parameters, $value[1]);
            }
          }else {
            $this->validate($key, $parameters, $value);
          }
        }catch (\Exception $e) {
          exit(__FUNCTION__ . " Err_text: {$key} " . $e);
        }
      }
    }catch (PDOException $e) {
      exit(__CLASS__ . ' - ' . __FUNCTION__ . ' Err_text: ' . $e);
    }

    $this->query->execute();

    if ($fetch) {
      if ($all) {
        return db_rus($this->query->fetchAll($fetch));
      }else {
        return db_rus($this->query->fetch($fetch));
      }
    }
  }
}
