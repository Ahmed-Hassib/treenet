<?php
// create an object of Transaction class
$trans_obj = new Transaction();
// get malfunctions of today
$transactions = $trans_obj->get_all_transactions(base64_decode($_SESSION['sys']['company_id']));
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start fs-12">
    <div class="col-12">
      <div class="section-block">
        <table class="table table-bordered table-striped display compact nowrap" data-scroll-x="false" data-last-td="null" style="width:100%">
          <thead class="primary text-capitalize">
            <tr>
              <th>#</th>
              <th>
                <?php echo lang('status', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('transaction id', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('price', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('currency', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('order id', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('data message', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('created at', $lang_file) ?>
              </th>
              <th>
                <?php echo lang('control') ?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php if ($transactions != null) { ?>
              <?php foreach ($transactions as $index => $trans) { ?>
                <tr class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                  <td><?php echo $index + 1 ?></td>
                  <td class="fs-12">
                    <?php if ($trans['is_success']) { ?>
                      <span class="badge rounded-pill bg-success p-2 px-4">
                        <?php echo lang('success') ?>
                      </span>
                    <?php } elseif ($trans['is_pending']) { ?>
                      <span class="badge rounded-pill bg-warning p-2 px-4">
                        <?php echo lang('pending') ?>
                      </span>
                    <?php } elseif ($trans['is_refunded']) { ?>
                      <span class="badge rounded-pill bg-warning p-2 px-4">
                        <?php echo lang('refunded') ?>
                      </span>
                    <?php } else { ?>
                      <span class="badge rounded-pill bg-danger p-2 px-4">
                        <?php echo lang('failed') ?>
                      </span>
                    <?php } ?>
                  </td>
                  <td><?php echo $trans['transaction_id'] > 0 ? $trans['transaction_id'] : "-" ?></td>
                  <td><?php echo $trans['price'] ?></td>
                  <td><?php echo $trans['currency'] ?></td>
                  <td><?php echo $trans['order_id'] ?></td>
                  <td><?php echo wordwrap(lang(strtoupper($trans['data_message'])), 50, "<br>") ?></td>
                  <td><?php echo $trans['created_at'] ?></td>
                  <td>
                    <a href="?do=details&transaction=<?php echo $trans['transaction_id'] ?>&order=<?php echo $trans['order_id'] ?>" class="btn btn-outline-primary">
                      <?php echo lang('details') ?>
                    </a>
                  </td>
                </tr>
              <?php } ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>