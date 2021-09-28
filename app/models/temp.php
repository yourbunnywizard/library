<?php require('connection.php') ?>

<?php

    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link));

    $query ="SELECT * FROM book";
    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
    $rows = mysqli_num_rows($result); // количество полученных строк

    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);        
        echo $row[0].' | '.$row[1];          
    }
  
    mysqli_free_result($result);
}
  
mysqli_close($link);

?>