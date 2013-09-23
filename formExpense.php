<?php
include './helpSource/helpFunctions.php';

error_reporting(0);
mb_internal_encoding('UTF-8');
my_header('Добавяне на нов разход');

?>
<a href="index.php">Списък</a><br />
<?php
    if($_POST)
    {
        $nameExpense   = trim($_POST['nameExpense']);
        /* This regular expression removes any special characters and numbers- only letters and interval remain
         * for example: 'a1s"D в$ф%ю.л,н56' becomes 'asD вфюлн'
         */
        $nameExpense = preg_replace('/[^\pL ]/u', '', $nameExpense);
        
        $amountExpense = trim($_POST['amountExpense']);
        
        /* Some countries use ',' for writing decimal numbers.
         * Replace ',' with '.'. The function 'is_numberic works '.'.
         */
        $amountExpense = str_replace(',', '.', $amountExpense);
        /* This regular expression removes any special characters and letters - only numbers, '.', '-' remain
         * for example: 'a1s"D в$ф%ю.л,н56' becomes '1.56'
         */
        $amountExpense = preg_replace('/[^0-9.-]/', '', $amountExpense);
        
        $typeExpense   = (int)$_POST['typeExpense'];
        
        if(mb_strlen($nameExpense) < 4)
        {
            $error_array['nameExpense'] = 'Името на продукта е прекалено късо!';
        }
        
        /* Still check whether this is a correct number.
         * A user can enter 1..23(even after processing with preg_replace()), which is wrong.
         */
        if(!is_numeric($amountExpense))
        {
            $error_array['amountExpense'] = 'Въведете правилна сума!';
        }
        else if(0 >= $amountExpense)
        {
            $error_array['amountExpense'] = 'Въведете положителна сума!';
        }
        
        if(count($error_array) == 0)
        {
            $today = date("d.m.Y");
            
            $record = $today.'|'.$nameExpense.'|'.$typeExpense.'|'.round($amountExpense, 2).PHP_EOL;
            
            if(file_put_contents("Expenses.txt", $record, FILE_APPEND) !== null)
            {
                $result = 'Успешно въведохте нов разход!';
            }
            else
            {
                $result = 'Проблем при записа на разхода!';
            }
            
            //echo "$record";
        }
        
    }
?>
<form method="POST" enctype="multipart/form-data" action="formExpense.php">
    Име: <input type="text" name="nameExpense" />
         <?php echo $error_array['nameExpense'];?>
         <br />
    Сума: <input type="text" name="amountExpense" />
          <?php echo $error_array['amountExpense'];?>
          <br />
    Вид: <?php listTypeExpenses($typeExpenses); ?><br />
    <input type="submit" value="Добави" name="submitForm" />
</form>
<?php
    echo $result.PHP_EOL;
my_footer();
?>
