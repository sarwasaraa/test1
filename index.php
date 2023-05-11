<a href='./dodaj.php'>Dodaj nową osobę</a>

<?php

require_once('./header.php');

$godzina = date('h');

if ($godzina >= 6 && $godzina < 12) {
    echo "<h1>Good Morning</h1>";
} else if ($godzina >= 12 && $godzina < 18) {
    echo "<h1>Good Afternoon</h1>";
} else {
    echo "<h1>Good Evening</h1>";
}


$serwer = 'localhost';
$uzytkownik = 'root';
$haslo = '';
$baza = 'ćwiczenia1_db';

$polaczenie = new mysqli($serwer, $uzytkownik, $haslo, $baza);

if ($polaczenie->connect_error) {
    die("Nie udało się połączyć");
} else {
    echo "<h1>Połączenie nawiązane</h1>";
}

$sql =
    "
SELECT 
e.id,
CONCAT(e.first_name, ' ', e.last_name) AS user, 
e.email,
j.title,
d.department_name
FROM employees AS e
INNER JOIN jobs AS j
ON e.job_id = j.id
INNER JOIN departments AS d
ON e.department_id = d.id
ORDER BY e.id
";

$wynik = $polaczenie->query($sql);


?>
<div class="wrapper">
    <?php

    if ($wynik->num_rows > 0) {

        while ($osoba = $wynik->fetch_assoc()) {
    ?>
            <div class="card">
                <h3> <?php echo $osoba['id'] ?>. <?php echo $osoba['user'] ?></h3>
                <p> <?php echo $osoba['title'] ?> - <?php echo $osoba['department_name'] ?> </p>
                <h5> <?php echo $osoba['email'] ?> </h5>
                <form action="./delete.php" method="post">
                    <input name="id" value="<?php echo $osoba['id']?>" type="hidden">
                    <button type="submit">Usuń</button>
                </form>
            </div>

    <?php
        }
    }

    ?>

</div>


</body>

</html>