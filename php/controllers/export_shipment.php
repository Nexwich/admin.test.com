<?php

/**
 * Выгрузка массовой отгрузки
 * @author Александр Панасин <nexwich@mail.ru>
 * @version 1.0.0
 */
class Controller_export_shipment extends Controller_Base {
  public function index () {
    $delivery_companies = new Delivery_Companies($this->registry, 'TradeTestRAV');

    $params['tag_title'] = 'Массовая отгрузка';
    $params['delivery_companies'] = $delivery_companies->getItems();
    $params['items'] = [];

    if (!empty($_GET['delivery_company_code'])) {
      $get_role = new Get_role($this->registry, 'TradeTestRAV');
      $storage = new Storage($this->registry, 'TradeTestRAV');
      $shipment_documents = new Shipment_Documents($this->registry, 'TradeTestRAV');
      $operators = $get_role->get_id('192.168.0.158'); //$_SERVER['REMOTE_ADDR']);
      $operator = $operators[0];
      $storage_id = $storage->get_id_by_operator_id((int) $operator['КодОператора']);

      $shipment_documents = $shipment_documents->getItems([
        'FilialID' => $storage_id,
        'TCID' => (int) $_GET['delivery_company_code'],
      ]);

      $params['items'] = $shipment_documents;
      $params['operator'] = $operator;
      $params['fields'] = [
        ['name' => 'ИмяТипаСущности', 'title' => 'Тип', 'short' => true,],
        ['name' => 'КодСущности', 'title' => 'Код', 'numeric' => true, 'short' => true,],
        ['name' => 'Получатель', 'title' => 'Клиент'],
        ['name' => 'НомерУПД', 'title' => 'Номер&nbsp;УПД', 'numeric' => true, 'short' => true,],
        ['name' => 'ДатаУПД', 'title' => 'Дата&nbsp;УПД', 'type' => 'date', 'short' => true,],
        ['name' => 'КолМест', 'title' => 'Мест', 'numeric' => true, 'short' => true,],
        ['name' => 'Вес', 'title' => 'Вес,&nbsp;кг', 'type' => 'numeric', 'divider' => 2,
          'numeric' => true, 'short' => true,],
        ['name' => 'Объем', 'title' => 'Объем,&nbsp;см<sup>3</sup>', 'type' => 'numeric',
          'divider' => 0, 'numeric' => true, 'short' => true,],
        ['name' => 'НомерТН', 'title' => 'ТН', 'numeric' => true, 'short' => true,],
      ];
    }

    $this->render('exports/shipment', $params);
  }

  public function document () {
    $shipment_masses = new Shipment_Masses($this->registry, 'TradeTestRAV');

    $params['tag_title'] = 'Массовая отгрузка';

    $params['items'] = $shipment_masses->getItems([
      'EntityTypeID' => (int) $_GET['EntityTypeID'],
      'EntityID' => (int) $_GET['EntityID'],
    ]);

    $params['fields'] = [
      ['name' => 'Место', 'title' => 'Место', 'type' => 'numeric', 'divider' => 0,
        'numeric' => true, 'short' => true,],
      ['name' => 'Упаковка', 'title' => 'Упаковка'],
      ['name' => 'Вес', 'title' => 'Вес,&nbsp;кг', 'type' => 'numeric', 'divider' => 2,
        'numeric' => true, 'short' => true,],
      ['name' => 'Ширина', 'title' => 'Ширина,&nbsp;см', 'type' => 'numeric', 'divider' => 1,
        'numeric' => true, 'short' => true,],
      ['name' => 'Высота', 'title' => 'Высота,&nbsp;см', 'type' => 'numeric', 'divider' => 1,
        'numeric' => true, 'short' => true,],
      ['name' => 'Глубина', 'title' => 'Глубина,&nbsp;см', 'type' => 'numeric', 'divider' => 1,
        'numeric' => true, 'short' => true,],
      ['name' => 'Объем', 'title' => 'Объем,&nbsp;см<sup>3</sup>', 'type' => 'numeric',
        'divider' => 0, 'numeric' => true, 'short' => true,],
    ];

    $this->render('exports/shipment_item', $params);
  }

  public function submit () {
    $shipment_documents = new Shipment_Documents($this->registry, 'TradeTestRAV');
    $get_role = new Get_role($this->registry, 'TradeTestRAV');
    $operators = $get_role->get_id('192.168.0.158'); // $_SERVER['REMOTE_ADDR']);
    $operator = $operators[0];

    $result = $shipment_documents->shipment([
      'UserID' => $operator['КодОператора'],
      'TotalWeight' => (float) str_replace(',', '.', $_POST['mass']),
      'JsonString' => $_POST['items'],
    ]);

    header('Location: http://192.168.0.130/get_file/transfer?code='
      . (int) $result['КодОтправки'] . '&oper=' . (int) $operator['КодОператора']
    );
  }
}
