<?php

/**
 * Массогабариты
 * @author Александр Панасин <nexwich@mail.ru>
 * @version 1.0.0
 */
class Shipment_Masses extends Model {
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
   * Документы отгрузки
   * @param array $params
   * @return array
   */
  public function getItems (array $params = []): array {
    if (!$this->items) {
      $this->items = $this->find('Отправки_МассОтгрузка_Массогабариты', $params);
    }

    return $this->items;
  }
}
