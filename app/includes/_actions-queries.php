<?php


function addSpending(PDO $dbCo)
{
    if (!isset($_POST['name']) || strlen($_POST['name'] <= 0)) {
        addError('name_ko');
    }

    if (!isset($_POST['date'])) {
        addError('date_ko');
    }

    if (!isset($_POST['amount']) || !is_numeric($_POST['amount']) || $_POST['amount'] === 0) {
        addError('amount_ko');
    }

    $queryAdd = $dbCo->prepare(
        'INSERT INTO transaction (name, amount, date_transaction, id_category)
            VALUES (:name, :amount, :date, :category);'
    );

    $bindValues = [
        'name' => htmlspecialchars($_POST['name']),
        'amount' => intval($_POST['amount']),
        'date' => validateDate($_POST['date']) ? date("Y-m-d", strtotime($_POST['date'])) : null,
        'category' => intval($_POST['category'])
    ];

    $isInsertOk = $queryAdd->execute($bindValues);

    if ($isInsertOk) {
        addMessage('insert_ok');
    }
    if (!$isInsertOk) {
        addError('insert_ko');
    }

    return $isInsertOk;
}
