<?php
// create an object of Pricing class
$pricing_obj = new Pricing();
// get all pricing plans
$pricing_plans = $pricing_obj->get_all_pricing_plans();
// get country id
$country_id = $pricing_obj->select_specific_column("`country_id`", "`companies`", "WHERE `company_id` = " . base64_decode($_SESSION['sys']['company_id']))['country_id'];
// get all clients numbers
$clients_counter = $pricing_obj->count_records("`id`", "`pieces_info`", "WHERE `is_client` = 1 AND `company_id` = " . base64_decode($_SESSION['sys']['company_id']));
?>
<div class="container">
  <div class="row row-cols-sm-12 row-cols-md-2 row-cols-lg-4 g-3 justify-content-center align-items-center">
    <?php foreach ($pricing_plans as $key => $plan) { ?>
      <div>
        <div class="section-block">
          <div class="section-header text-center">
            <h2 class="h2 text-capitalize">
              <?php echo $page_dir == 'rtl' ? $plan['name_ar'] : $plan['name_en'] ?>
            </h2>
            <?php if (base64_decode($_SESSION['sys']['plan_id']) == $plan['id']) { ?>
              <h3>
                <span class="badge bg-primary">
                  <?php echo lang('CURRENT PLAN') ?>
                </span>
              </h3>
            <?php } ?>
            <h3 class="h3 text-capitalize">
              <?php
              // get price
              $price = $plan['price_eg'];
              // get currency
              $currency = 'L.E';
              // period
              $period = lang('MONTH');
              ?>
              <span class="fw-bold" style="font-size:24px!important">
                <?php echo $price ?>
              </span>
              <span class="fs-12">
                <?php echo lang($currency) . '/' . $period ?>
              </span>
            </h3>
            <!-- custom separator -->
            <div class="custom-separator mx-auto"></div>
          </div>
          <div>
            <ul class="p-0" style="list-style: none;">
              <li>
                <i class="text-primary bi bi-person-check-fill"></i>
                <span>
                  <?php echo $plan['clients'] . "&nbsp;" . lang('ClT', 'clients') ?>
                </span>
              </li>
              <li>
                <i class="text-primary bi bi-database-fill-check"></i>
                <?php echo $plan['space'] / 1000 . "GB&nbsp;" . lang('CAPACITY STORAGE') ?>
              </li>
            </ul>
            <?php if ($clients_counter < $plan['clients']) { ?>
              <div class="mt-5 hstack">
                <button type="button" class="mx-auto w-100 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#paymentMethodTypeModal" data-price="<?php echo $plan['price_eg'] ?>" data-currency="<?php echo 'EGP' ?>" data-plan="<?php echo base64_encode($plan['id']) ?>">
                  <?php echo lang('SUBSCRIBE') ?>
                </button>
              </div>
            <?php } else { ?>
              <span class="text-danger">
                <i class="bi bi-exclamation-triangle"></i>
                <?php echo lang('PLAN DOSN`T SUIT YOU', $lang_file) ?>
              </span>
            <?php } ?>
          </div>
        </div>
      </div>

    <?php } ?>
  </div>
</div>

<div class="modal fade" id="paymentMethodTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentMethodTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="paymentMethodTypeModalLabel">
          <?php echo lang('PAYMENT METHOD') ?>
        </h1>
        <button type="button" class="btn-close btn-close-<?php echo $page_dir == 'rtl' ? 'left' : 'right' ?>" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="lead text-capitalize text-center">
          <?php echo lang('SELECT PAYMENT METHOD') ?>
        </p>
        <div class="mt-3 hstack gap-3 justify-content-center">
          <!-- for mobile wallet  -->
          <a href="" class="btn btn-outline-primary" id="mobile-wallet-link">
            <i class="bi bi-wallet"></i>
            <?php echo lang('MOBILE WALLET') ?>
          </a>
          <!-- for card paymet -->
          <a href="" class="btn btn-outline-primary" id="card-payment-link">
            <i class="bi bi-credit-card-2-front"></i>
            <?php echo lang('CARD PAYMENT') ?>
          </a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary fs-12 py-1" data-bs-dismiss="modal">
          <?php echo lang('close') ?>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  // get modal element
  const payment_method_modal = document.querySelector('#paymentMethodTypeModal')
  // select mobile wallet link
  let mobile_wallet_link = document.querySelector('#mobile-wallet-link');
  // select card payment link
  let card_payment_link = document.querySelector('#card-payment-link');

  // while closed clear all data
  payment_method_modal.addEventListener('shown.bs.modal', event => {
    // get data
    let plan = event.relatedTarget.dataset.plan;
    let price = event.relatedTarget.dataset.price;
    let currency = event.relatedTarget.dataset.currency;
    // prepare link
    let href_link = `?do=pay&plan=${plan}&currency=${currency}`;
    // put href link
    mobile_wallet_link.href = `${href_link}&method=wallet`;
    card_payment_link.href = `${href_link}&method=card`;
  })

  // while closed clear all data
  payment_method_modal.addEventListener('hidden.bs.modal', event => {
    mobile_wallet_link.href = '';
    card_payment_link.href = '';
  })
</script>