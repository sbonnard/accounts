<?php

if(!empty($_POST)) {
    if($_POST['action'] === 'add-spending') {
        
        if(strlen($_POST['name'] <= 0)) {
            addError('name_ko');
        }
    }
}