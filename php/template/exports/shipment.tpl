<?
/**
 * Результат в зависимости от количества
 * @param $n
 * @param $titles Значения для вывода ['1еденица', '2еденицы', '5едениц']
 */
function numeral_inclination ($n, $titles = []) {
  $cases = [2, 0, 1, 1, 1, 2];
  return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
}

/**
* Вернуть цвет текста
* @param $overall
* @return string
*/
function style_overall ($overall) {
switch($overall) {
case 1:
return 'table-warning';
case 2:
return 'table-danger';
default:
return '';
}
}

$total_items = count($items);
$total_mass = 0;
$total_volume = 0;
$total_places = 0;

if ($total_items and empty($items['КодОшибки'])) {
foreach ($items as $item) {
$total_mass += (int) $item['Вес'];
$total_volume += (int) $item['Объем'];
$total_places += (int) $item['КолМест'];
}
}
?>

<div class="header_wrapper">
  <div class="header">
    <h1 class="h3">
      <a class="btn btn-light btn-sm hide" id="brod"><i class="fa fa-bars"></i></a> Массовая отгрузка
    </h1>
  </div>
</div>

<section class="row" style="height: calc(95vh - 1rem);">
  <style>
    .text-orange { color:#fd7e14; }
    .dataTables_scrollBody { min-height:calc(94vh - 178px - 52px); }
    .js-ajax { cursor:pointer; }
  </style>

  <div class="col">
    <div class="card card mx-2" style="height: calc(94vh);">
      <? if (!empty($delivery_companies)) { ?>
      <div class="card-header px-2 py-0">
        <form action="" method="get">
          <input type="hidden" name="mode" value="export">
          <input type="hidden" name="storage_code" value="-1">

          <div class="form-group row mt-2 mb-2">
            <label for="query" class="col-form-label col-auto">ТК</label>

            <div class="col-auto">
              <select id="query" class="form-select custom-select" name="delivery_company_code">
                <? foreach ($delivery_companies as $item) { ?>
                <option
                  value="<?= $item['КодТК'] ?>"
                <? if (!empty($_GET['delivery_company_code']) and $item['КодТК'] == $_GET['delivery_company_code']) { ?>
                selected='selected'
                <? } ?>
                >
                <?= $item['ИмяТК'] ?>
                </option>
                <? } ?>
              </select>
            </div>

            <div class="col-auto">
              <button class="btn btn-primary" type="submit">Сформировать список</button>
            </div>
          </div>
        </form>
      </div>
      <? } ?>

      <? if (empty($items['КодОшибки'])) { ?>
      <? if (!empty($_GET['mode']) and $_GET['mode'] == 'export' and $total_items) { ?>
      <div class="card-body">
        <form action="/export_shipment/submit" method="post" target="_blank">
          <input type="hidden" name="delivery_company_code" value="<?= $_GET['delivery_company_code'] ?>">
          <input type="hidden" name="items" value='<?= json_encode($items, JSON_UNESCAPED_UNICODE) ?>'>

          <table
            class="table table-striped table-hover js-data-table"
            data-table='{
              "scrollY": "calc(94vh - 178px - 52px)",
              "scrollCollapse": true,
              "paging": false,
              "searching": false,
              "info": false,
              "ordering": false
            }'
          >
            <thead class="thead-light">
              <tr class="table-secondary">
                <?php foreach ($fields as $field) { ?>
                <th
                  class="<? if (!empty($field['numeric']) and $field['numeric']) { ?>text-right<? } ?>"
                <? if (!empty($field['short']) and $field['short']) { ?>style="width:1%"<? } ?>
                >
                <?= $field['title'] ?>
                </th>
                <?php } ?>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($items as $item) { ?>
              <tr
                class="<?= style_overall($item['Негабарит']) ?> js-ajax"
                data-toggle="modal"
                data-target="#shipmentModal"
                data-ajax='{
                "url": "/export_shipment/document?EntityTypeID=<?= $item["КодТипаСущности"] ?>&EntityID=<?= $item["КодСущности"] ?>",
                "insertSelector": "#shipmentModal .js-ajax--content",
                "selector": ".js-ajax--data"
              }'
              >
                <?php foreach ($fields as $field) {
                $value = $item[$field['name']];

                if (!empty($field['type']) and $field['type'] == 'numeric' and $value) {
                  $value = number_format($value, $field['divider'], ',', ' ');
                }

                if (!empty($field['type']) and $field['type'] == 'date' and $value) {
                  $value = date('d.m.Y', strtotime($value));
                }
                ?>
                <td
                <? if (!empty($field['numeric']) and $field['numeric']) { ?>class="text-right"<? } ?>>
                <?= $value ?>
                </td>
                <?php } ?>
              </tr>
              <?php } ?>
            </tbody>

            <tfoot>
              <tr>
                <td>Итого:</td>
                <td class="text-right"><?= $total_items ?></td>

                <td colspan="3">
                  <?= numeral_inclination(
                  $total_items,
                  ['отправка', 'отправки', 'отправок']
                ) ?>
                </td>

                <td class="text-right">
                  <?= $total_places ?>&nbsp;<?= numeral_inclination(
                  $total_places,
                  ['место', 'места', 'мест']
                ) ?>
                </td>

                <td class="text-right"><?= number_format($total_mass, 2, ',', '&nbsp;') ?>&nbsp;кг</td>

                <td class="text-right">
                  <?= number_format($total_volume / 10e3, 0, ',', '&nbsp;')?>&nbsp;м<sup>3</sup>
                </td>

                <td></td>
              </tr>

              <tr class="card-footer">
                <td colspan="7">
                  <div class="row">
                    <div class="col-auto">
                      <div class="text-danger"><small>Все места не габаритные</small></div>
                      <div class="text-orange"><small>Некоторые места не габаритные</small></div>
                    </div>

                    <div class="col text-right">
                      Общий вес при взвешивании:
                      <label>
                        <input
                          type="number"
                          step="0.01"
                          class="form-control text-right"
                          name="mass"
                          value="<?= $total_mass ?>"
                        >
                      </label>
                      кг
                    </div>
                  </div>
                </td>

                <td colspan="2">
                  <button class="btn btn-primary btn-block" type="submit">Отгрузить</button>
                </td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
      <? } elseif (!empty($items['КодОшибки'])) { ?>
      <div class="card-header">
        <div class="mt-2 mb-2">
          <p><?= $items['КодОшибки'] ?>. <?= $items['ОписаниеОшибки'] ?></p>
        </div>
      </div>
      <? } else { ?>
      <div class="card-header">
        <div class="mt-2 mb-2">
          <p>По данному запросу ничего не найдено</p>
        </div>
      </div>
      <? } ?>
      <? } ?>
    </div>
  </div>
</section>

<div class="modal" tabindex="-1" id="shipmentModal">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content js-ajax--content"></div>
  </div>
</div>
