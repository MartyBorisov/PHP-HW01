<?php
include './helpSource/helpFunctions.php';

error_reporting(0);
my_header('Добави разход');
$totalAmount = 0;
?>
<a href="formExpense.php">Добави нов разход</a>

<form method="POST" action='index.php'>
    <?php
    listTypeExpenses($typeExpenses, 1);
    ?>
    <input type='submit' value="Филтрирай" name="submitFilter" />
</form>

<hr />

<table border="1px solid black">
    <tr>
        <th>Дата</th>
        <th>Име</th>
        <th>Вид</th>
        <th>Сума</th>
    </tr>
<?php

if(file_exists("Expenses.txt"))
{
    $resultFile = file("Expenses.txt");
    
    foreach($resultFile as $val)
    {
        echo "<tr>";
        
        $dataColumn = explode("|", $val);
        
        /* get the last element from the array */
        $lastKey = (int)array_pop(array_keys($dataColumn));
        
        /* cast to INT, so the initial page will show all items */
        $filter = (int)$_POST['typeExpense'];
        
        if($filter > 0 && $filter != (int)$dataColumn[$lastKey - 1])
        {
            //do nothing - just pass to the end to close <tr> tag.
        }
        else
        {
            foreach($dataColumn as $key=>$valCol)
            {
                if($key == ($lastKey - 1))
                {
                    /* for the 'GROUP' element we have to convert the value using the array $typeExpense */
                    echo "<td>".$typeExpenses[(int)$dataColumn[$key]]."</td>";
                }
                else
                {
                    echo "<td>$valCol</td>";
                    if($key == $lastKey)
                    {
                        /* get the total Amount */
                        $totalAmount += $dataColumn[$key];
                    }
                }
            }
        }
        
        echo "</tr>";
    }
}
?>
    <tr>
        <td>---</td>
        <td>---</td>
        <td>---</td>
        <td><?= $totalAmount; ?></td>
    </tr>
</table>
<?php

my_footer();

?>