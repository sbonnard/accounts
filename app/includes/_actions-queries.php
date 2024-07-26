<?php


function addSpending(PDO $dbCo)
{
    $errors = [];


    if (!isset($_POST['name']) || strlen($_POST['name'] <= 0)) {
        addError('name_ko');
        $errors[] = 'erreur nom';
    }

    if (!isset($_POST['date'])) {
        addError('date_ko');
        $errors[] = 'erreur date';
    }

    if (!isset($_POST['amount']) || !is_numeric($_POST['amount']) || $_POST['amount'] === 0) {
        addError('amount_ko');
        $errors[] = 'erreur montant';
    }

    if (empty($errors)) {
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
    if (!empty($errors)) {
        addError('insert_ko');
    }
}
