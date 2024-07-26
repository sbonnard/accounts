<?

/**
 * Fetches datas from table "transaction" from database
 *
 * @param PDO $dbCo - The connection to database.
 * @return array - The array containing datas.
 */
function fetchTransactions(PDO $dbCo): array
{
    $query = $dbCo->query('
    SELECT *
    FROM transaction
    ORDER BY date_transaction DESC;');

    $datasTransaction =  $query->fetchAll(PDO::FETCH_ASSOC);

    return $datasTransaction;
}


/**
 * Calculates Balance of a user after all his/her transactions
 *
 * @param PDO $dbCo - Connection to database.
 * @return array - An array containing the total of money left.
 */
function calculateBalance(PDO $dbCo):array
{
    $queryBalance = $dbCo->query(
        'SELECT SUM(amount) AS total_balance
        FROM transaction;'
    );

    $balance = $queryBalance->fetchAll();

    return $balance;
}
