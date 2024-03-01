<?php


class Transaction extends Database
{
  // properties
  public $con;

  // table name
  public $table_name = 'transactions';

  // constructor
  public function __construct()
  {
    // create an object of Database class
    $db_obj = new Database("localhost", "jsl_db", "root", "@hmedH@ssib");

    $this->con = $db_obj->con;
  }

  // get all transactions
  public function get_all_transactions($company_id)
  {
    // select transactions info query
    $transactions_info_query = "SELECT *FROM `{$this->table_name}` WHERE `company_id` = ?";
    // prepare the query
    $stmt = $this->con->prepare($transactions_info_query); // select all transactions
    $stmt->execute(array($company_id)); // execute data
    $transactions_info = $stmt->fetchAll(); // assign all data to variable
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? $transactions_info : null;
  }

  // get all pricing
  public function get_transaction($company_id, $transaction_id, $order_id)
  {
    // select pricing info query
    $transaction_info_query = "SELECT *FROM `{$this->table_name}` WHERE `company_id` = ? AND `transaction_id` = ? AND `order_id` = ? LIMIT 1;";
    // prepare the query
    $stmt = $this->con->prepare($transaction_info_query); // select all pricing
    $stmt->execute(array($company_id, $transaction_id, $order_id)); // execute data
    $rows = $stmt->fetch(); // assign all data to variable
    $count = $stmt->rowCount(); // all count of data

    // check count
    if ($count > 0) {
      extract($rows);

      return [
        "id" => $id,
        "company_id" => $company_id,
        "transaction_id" => $transaction_id,
        "is_success" => $is_success,
        "is_pending" => $is_pending,
        "is_refunded" => $is_refunded,
        "price" => $price,
        "order_id" => $order_id,
        "currency" => $currency,
        "is_error_occured" => $is_error_occured,
        "source_data_type" => $source_data_type,
        "source_data_pan" => $source_data_pan,
        "txn_response_code" => $txn_response_code,
        "hmac" => $hmac,
        "data_message" => $data_message,
        "created_at" => $created_at,
        "updated_at" => $updated_at,
      ];
    }

    // return
    return null;
  }

  public function insert_transaction($info)
  {
    // insert pricing info query
    $pricing_info_query = "INSERT INTO `{$this->table_name}` (`company_id`, `transaction_id`, `is_success`, `is_pending`, `is_refunded`, `price`, `order_id`, `currency`, `is_error_occured`, `source_data_type`, `source_data_pan`, `txn_response_code`, `hmac`, `data_message`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    // prepare the query
    $stmt = $this->con->prepare($pricing_info_query); // insert pricing
    $stmt->execute($info); // execute data
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? true : false;
  }

  public function update_transaction($info)
  {
    // insert pricing info query
    $pricing_info_query = "UPDATE `{$this->table_name}` SET `transaction_id` = ?, `is_success` = ?, `is_pending` = ?, `is_refunded` = ?, `price` = ?, `currency` = ?, `is_error_occured` = ?, `source_data_type` = ?, `source_data_pan` = ?, `txn_response_code` = ?, `hmac` = ?, `data_message` = ?, `created_at` = ?, `updated_at` = ? WHERE `company_id` = ? AND `order_id` = ?;";
    // prepare the query
    $stmt = $this->con->prepare($pricing_info_query); // insert pricing
    $stmt->execute($info); // execute data
    $count = $stmt->rowCount(); // all count of data
    // return
    return $count > 0 ? true : false;
  }
}
