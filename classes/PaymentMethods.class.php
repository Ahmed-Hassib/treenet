<?php


class PaymentMethods extends Database
{

  private $TABLE_NAME = 'payment_methods';

  public function get_all_payment_methods($company_id) {
    $query = "SELECT *FROM `{$this->TABLE_NAME}` WHERE `company_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($query);
    $stmt->execute(array($company_id));
    $payment_info = $stmt->fetchAll();
    $payment_count = $stmt->rowCount(); // count effected rows
    // return result
    return $payment_count > 0 ? $payment_info : null;
  }
}