<?php

$typeExpenses = array(0=>'Всички', 1=>'Храна', 2=>'Цигари', 3=>'Алкохол', 4=>'Дрехи', 5=>'Домашни потреби',
                      6=>'Техника', 7=>'Други');

function my_header($titlePage) {
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html>
        <head>
            <meta htpp-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title><?php echo $titlePage; ?></title>
        </head>
        <body>
    <?php
}

function my_footer() {
    ?>
        </body>
    </html>
    <?php
}

/*
 * $typeExpenses - the array with possible types items
 * $addParam - default value = 0 - do not show the 'All' label;
 *                             1 - show the 'All' label.
 */
function listTypeExpenses($typeExpenses, $addParam=0)
{
    ?>
    <select name="typeExpense">
            <?php
                foreach($typeExpenses as $key=>$value)
                {
                    if($addParam == 0 && $key == 0)
                    {
                        continue;
                    }
                    if((int)$_POST['typeExpense'] == $key)
                    {
                        echo "<option value=$key selected='selected'>$value</option>";
                    }
                    else
                    {
                        echo "<option value=$key>$value</option>";
                    }
                }
            ?>
    </select>
    <?php
}
?>
