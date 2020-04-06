<html>

<head>
        <title> Gallery </title>
</head>
<?php
  
  $dbh = new PDO('mysql:host=localhost;dbname=davidmt1997', 'randy', '');
  $query = "SELECT id FROM pics;";
  $stmt = $dbh->prepare($query);
  $stmt->execute();
  $rows = $stmt->fetchAll();
  foreach ($rows as $row) {
    # code...
    $id = $row['id'];
    echo "<a href=displaypic.php?id=$id> <img src='displaypic.php?id=$id' height='300' width='300'></a>";
  }
?>
</html>
