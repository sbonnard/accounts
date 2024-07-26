<?

/**
 * Fetches datas from table "transaction" from database
 *
 * @param PDO $dbCo - The connection to database.
 * @return array - The array containing datas.
 */
function fetchTransactions(PDO $dbCo):array {
    $query = $dbCo->query('
    SELECT *
    FROM transaction
    ORDER BY date_transaction DESC');

    $datasTransaction =  $query->fetchAll(PDO::FETCH_ASSOC);

    return $datasTransaction;
}