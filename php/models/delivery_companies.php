<?php

/**
 * Транспортные компании
 * @author Александр Панасин <nexwich@mail.ru>
 * @version 1.0.0
 */
class Delivery_Companies extends Model {
  protected $items = [];

  public function rules (): array {
    return [
      [['КодПоставщика', 'КодПрайса', 'КодГруппы', 'КодСерии', 'КодТовара', 'ДопФильтры',
        'Активный', 'РФ', 'ВЭД', 'Импорт', 'КодПрофиляУсловийПрайса', 'КодСемейства', 'Удаление',
        'Привязка'], 'integer'],
      [['КодыТоваровЦены', 'Условия', 'ИмяСерии', 'КодыСемейств', 'КодыТоваров'], 'string'],
    ];
  }

  use traits\procedure;
  use traits\find;

  /**
   * Транспортные коммпании
   * @return array
   */
  public function getItems (): array {
    if (!$this->items) {
      $this->items = $this->find('Отправки_МассОтгрузка_РежимыТК_Список');
    }

    return $this->items;
  }
}
