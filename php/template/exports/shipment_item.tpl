<div class="card js-ajax--data">
  <div class="modal-header">
    <h5 class="modal-title">Массогабариты: Счет <?= $_GET['EntityID'] ?></h5>

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
  </div>

  <div class="modal-body ">
    <table class="table table-striped table-hover">
      <?php if (!empty($fields)) { ?>
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
      <?php } ?>

      <?php if (!empty($items) and !empty($fields)) { ?>
      <tbody>
        <?php foreach ($items as $item) { ?>
        <tr>
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
            class="<? if ($item[$field['name'] . 'НГ']) { ?>text-danger<? } ?> <?php if (!empty($field['numeric']) and $field['numeric']) { ?>text-right<?php } ?>"
          >
            <?= $value ?>
          </td>
          <? } ?>
        </tr>
        <?php } ?>
      </tbody>
      <?php } ?>
    </table>
  </div>
</div>
