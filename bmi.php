<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl3.css">
    <title>Twoje BMI</title>
</head>
<body>
    <header id="logo">
        <img src="wzor.png" alt="wzór BMI">


    </header>
    <header id="baner">
        <h1>Oblicz swoje BMI</h1>
        
    </header>
    <main id="glowny">
        <table>
            <tr>
                <td>Interpretacja BMI</td>
                <td>Wartość minimalna</td>
                <td>Wartość maksymalna</td>
            </tr>
            <?php
            #skrypt 1
            ini_set('display_errors', 0);
            $db = mysqli_connect("localhost","root","","egzamin");
            $error = mysqli_connect_error();
            $dberr = "<h1>Nie udało się połączyć z bazą: </h1>";
            
            if ($error) {
                $errno  = mysqli_connect_errno();
                echo "<div id='error'>";
                switch ($errno) {
                   
                    case '2002':
                        echo "$dberr <h1>błąd w nazwie hosta <br> $error</h1></div>";
                        exit();
                        break;
                    case '1045':
                        echo "$dberr <h1>błąd w nazwie użytkownika lub nieprawidłowe hasło <br> $error</h1></div>";
                        exit();
                        break;
                    case '1049':
                        echo "$dberr <h1>błąd w nazwie bazy danych <br> $error</h1></div>";
                        exit();
                        break;
                    
                    default:
                        echo "<h1>inny błąd $errno, $error</h1></div>";
                        exit();
                        break;
                        
                }
               
                
               
            }
           




            $query = "SELECT 
            bmi.informacja,
            bmi.wart_min, 
            bmi.wart_max FROM BMI;";
            if (!mysqli_query($db,$query)){
                echo "<div id='error'>";
                $errno = mysqli_errno($db);
                $error = mysqli_error($db);
                switch ($errno) {
                    case '1054':
                        echo "<h1>Błąd w nazwie kolumny: <br> $error </h1></div>";
                        break;
                    case '1146':
                        echo "<h1>Błąd w nazwie tabeli: <br> $error </h1></div>";
                        break;
                    case '1064':
                        echo "<h1>Błąd w składni: <br> $error </h1></div>";
                        break;
                    default:
                        echo "<h1>Inny błąd $errno $error</h1></div>";
                        break;
                }
            }
            $result = mysqli_query($db,$query);
            while ($row = mysqli_fetch_row($result)) {
                echo "<tr><td>$row[0]</td>";
                echo "<td>$row[1]</td>";
                echo "<td>$row[2]</td></tr>";
                
            }
         
           
             
            
           
             
               
                
            

            ?>



        </table>

    </main>
    <section id="left">
        <h2>Podaj wagę i wzrost</h2>
        <form action="" method="POST">
            <label for="waga">Waga</label><br>
            <input type="number" name="waga" id="waga" min="1"><br>
            <label for="wzrost">Wzrost w cm:</label><br>
            <input type="number" name="wzrost" id="wzrost" min="1"><br>
            <input type="submit" value="Oblicz i zapamiętaj wynik">
        </form>
            <?php
            #skrypt2
           
            $waga = $_POST['waga'];
            $wzrost = $_POST['wzrost'];
            if (!empty($waga) and !empty($wzrost)) {
                
               $bmi = $waga / ($wzrost * $wzrost) * 10000;

               echo "Twoja waga: $waga; Twój wzrost $wzrost <br> BMI wynosi: $bmi";
                
            } 
            $data = date("Y-m-d");
            $bmi_id = 0;
            if (!empty($bmi) and !empty($waga) and !empty($wzrost) ) {
                switch ($bmi) {
                    case 'niedowaga':
                        if($bmi <= 18) {
                            $bmi_id = 1;
                        }
                        break;
                    case 'waga prawidłowa':
                        if($bmi <= 25 and $bmi >= 19 ) {
                            $bmi_id = 2;
                        }
                        break;
                    case 'nadwaga':
                            if($bmi <= 26 and $bmi >= 30) {
                                $bmi_id = 3;
                            }
                            break;
                    case 'otylosc':
                            if($bmi <= 31 and $bmi >= 100) {
                                $bmi_id = 4;
                            }
                            break;
                    
                    default:
                        break;
                }
                $query1 = "INSERT INTO wynik (id, bmi_id, data_pomiaru, wynik) 
                VALUES (NULL, $bmi_id,'$data', $bmi)";
                $result = mysqli_query($db,$query1);
                if (!mysqli_query($db,$query1)){
                    echo "<div id='error'>";
                    $errno = mysqli_errno($db);
                    $error = mysqli_error($db);
                    switch ($errno) {
                        case '1054':
                            echo "<h1>Błąd w nazwie kolumny: <br> $error </h1>";
                            echo "</div>";
                            break;
                        case '1146':
                            echo "<h1>Błąd w nazwie tabeli: <br> $error </h1>";
                            echo "</div>";
                            break;
                        case '1064':
                            echo "<h1>Błąd w składni: <br> $error </h1>";
                            echo "</div>";
                            break;
                        default:
                            echo "<h1>Inny błąd $errno $error</h1>";
                            echo "</div>";
                            break;
                    }
                }
            } 



            mysqli_close($db);
            ?>

    </section>
    <section id="right">
        <img src="rys1.png" alt="ćwiczenia">
    

    </section>
    <footer id="stopka">
        Autor: Filip
        <a href=kwerendy.txt>Zobacz kwerendy</a>


    </footer>
</body>
</html>