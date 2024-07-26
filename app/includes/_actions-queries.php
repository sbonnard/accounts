<?php

/**
 * Checks errors in form completion and adds errors if needed.
 *
 * @return void
 */
function checkFormInfosTransaction(): void
{
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
}

/**
 * Add a transaction into database.
 *
 * @param PDO $dbCo - Connection to database.
 * @return bool
 */
function addSpending(PDO $dbCo):bool
{
    $errors = [];

    checkFormInfosTransaction();

    if (empty($errors)) {
        $queryAdd = $dbCo->prepare(
            'INSERT INTO transaction (name, amount, date_transaction, id_category)
            VALUES (:name, :amount, :date, :category);'
        );

        $bindValues = [
            'name' => htmlspecialchars($_POST['name']),
            'amount' => floatval($_POST['amount']),
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

/**
 * Updates transaction's infos with a form.
 *
 * @param [type] $dbCo - Connection to database.
 * @return bool
 */
function updateTransaction(PDO $dbCo):bool
{
    $errors = [];

    checkFormInfosTransaction();

    if (empty($errors)) {
        $queryUpdate = $dbCo->prepare(
            'UPDATE transaction
            SET name = :name, amount = :amount, date_transaction = :date, id_category = :category
            WHERE id_transaction = :id;'
        );

        $bindValues = [
            'name' => htmlspecialchars($_POST['update-name']),
            'amount' => floatval($_POST['update-amount']),
            'date' => validateDate($_POST['update-date']) ? date("Y-m-d", strtotime($_POST['update-date'])) : null,
            'category' => intval($_POST['update-category']),
            'id' => intval($_POST['id_transaction'])
        ];

        $isUpdateOk = $queryUpdate->execute($bindValues);

        if ($isUpdateOk) {
            addMessage('update_ok');
        }
        if (!$isUpdateOk) {
            addError('update_ko');
        }

        return $isUpdateOk;
    }
}
