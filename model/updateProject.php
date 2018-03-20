<?php

    $valid = true;
    //make sure its the project and company fields is not empty
    if($_POST['form'] == 'updateProject') {

        if(empty($post['pTitle']) || empty($post['description'])
            || empty($post['url']) || empty($post['trello'])) {
            $valid = false;
            echo "error";
            return;
        }

    } else if($_POST['form'] == 'updateCompany') {
        if(empty($post['cName']) || empty($post['cLocation'])
            || empty($post['cSite'])) {
            $valid = false;
            echo "error";
            return;
        }
    }
    //class info fields must not be empty
    else if ($_POST['form'] =='updateClass') {
        $index = 0;
        while($index < sizeof($post['className'])) {
            if(empty($post['className'][$index]) || empty($post['quarter'][$index])
                || empty($post['instructor'][$index])) {
                $valid = false;
                echo "error";
                return;
            }
            $index++;
        }

    }
    //contact info fields must not be empty
    else if ($_POST['form'] == 'updateContact') {
        $index = 0;
        while($index < sizeof($post['contactName'])) {
            if(empty($post['contactName'][$index]) || empty($post['title'][$index])
                || empty($post['phone'][$index]) || empty($post['email'][$index])) {
                $valid = false;
                echo "error";
                return;
            }
            $index++;
        }
    }




