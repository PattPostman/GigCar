<?php
    session_start();

    //SPRAWDZANIE LOGOWANIA DO ADMINA
    if(isset($_SESSION['zalogowany']) AND $_SESSION['zalogowany'] == 1){
        header("Location:managment.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Rent</title>
     <!--Css-->
    <link rel="stylesheet" href="main_style.css">
    <!--Icons-->
    <script src="https://kit.fontawesome.com/7d12fad211.js" crossorigin="anonymous"></script>
    <!--Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
</head>
<body>
    <div id="nav">
        <a href="main.php"><img id="nav_logo" src="zdjecia/black_logo.JPG"></a>
        <i class="fa-regular fa-user nav_icons login-form-icon" id="login_icon" style="cursor: pointer;">
        </i>
        <div id="pop_up_login_form">
            <form onsubmit="return loginForm()" action="login.php" method="post">
                <input type="text" name="login" placeholder="Login" class="input-form"><br>
                <input type="password" name="password" placeholder="Password" class="input-form"><br>
                <input type="submit" value="Login" style="cursor: pointer;">
            </form>
        </div>
    </div>
    <div id="main">
        <img id="main_bcg_photo" src="zdjecia/main_bcg.jpg">
        
        <div id="select-date">
            <div style="text-align: center; color:white;">
                <h1 style="margin-top:0;">Rent your car</h1>
                <h2>Select date to view available cars.</h2>
                <form action="main.php#cars-list" method="post" >
                    <div style="display:flex; justify-content: space-evenly">
                        <div>
                            <p>Pick-up Date</p>
                            <input type="date" name="from-date" id="from-date" style="border-radius: 5px; padding: 2px;" required>
                        </div>
                        <div>
                            <p>Drop-off Date</p>
                            <input type="date" name="to-date" id="to-date" min="" style="border-radius: 5px; padding: 2px;" required>
                        </div>
                    </div>
                    <p>Pick-up place</p>
                    <select name="location" style="border-radius: 5px; padding: 2px;">
                        <?php
                            //WYPISYWANIE MIAST DO WYBRANIA Z TABLICY miejsca_pobytu
                            $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                            $i = 1;
                            $tab1 ="SELECT id_miejsca, nazwa_miasta FROM miejsca_pobytu";
                            $wynik = mysqli_query($baza, $tab1) or die(mysqli_error($baza));
                            while($wiersz = mysqli_fetch_array($wynik)){
                                echo('<option value="'.$i.'">'.$wiersz['nazwa_miasta'].'</option>');
                                $i++;
                            }

                            mysqli_close($baza);
                        ?>
                    </select><br>
                    <input type="submit" value="Check available cars." id="submit-but"></input>
                </form>
            </div>
            
        </div>
    </div>

    <div id="cars-list">
        <?php
            //POBIERANIE DANYCH Z FORMULARZA
            $from_date = @$_POST['from-date'];
            $to_date = @$_POST['to-date'];
            $location = @$_POST['location'];

            //SPRAWDZANIE CZY ZOSTALY WPROWADZONE DATY WYPOZYCZENIA
            if(isset($from_date) AND isset($to_date) AND isset($location))
            {
                //ZAPISYWANIE DANYCH Z FORMULARZA W SESJI
                $_SESSION['from_date'] = $_POST['from-date'];
                $_SESSION['to_date'] = $_POST['to-date'];
                $_SESSION['location'] = $_POST['location'];
                
                $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');

                //TWORZENIE TABLICY TLUMACZOCEJ NAZWY MIAST
                $_SESSION['locations_names'] = array();

                $select_miasta = "SELECT id_miejsca, nazwa_miasta FROM miejsca_pobytu";
                $miasta = mysqli_query($baza, $select_miasta) or die(mysqli_error($baza));
                while($wynik_miasta = mysqli_fetch_array($miasta)){
                    $_SESSION['locations_names'][$wynik_miasta['id_miejsca']] = $wynik_miasta['nazwa_miasta'];
                }
                
                //DEKLAROWANIE ZMIENNYCH Z SELECTAMI
                $select_wypozyczone = "SELECT id_samochodu, od_kiedy, do_kiedy FROM wypozyczenie";
                $select_samochody = "SELECT id_samochodu, marka, model, ilosc_miejsc, pojemnosc_bagaznika, moc_silnika, paliwo, skrzynia_biegow, rocznik, cena_wypozyczenie_doba, id_miejsca, sciezka_zdjecia FROM samochody";

                $samochody = mysqli_query($baza, $select_samochody) or die(mysqli_error($baza));
                //SPRAWDZANIE KAZDEGO SAMOCHODU Z TABLICY samochody
                while($wynik_samochody = mysqli_fetch_array($samochody)){
                    $wypisz = false;

                    $wypozyczone = mysqli_query($baza, $select_wypozyczone) or die(mysqli_error($baza));
                    while($wynik_wypozyczenia = mysqli_fetch_array($wypozyczone)){
                        //SPRAWDZANIE DOSTEPNOSCI AUT
                        if($wynik_samochody['id_miejsca'] == $location){
                            if($wynik_wypozyczenia['id_samochodu'] == $wynik_samochody['id_samochodu'] AND $from_date < $wynik_wypozyczenia['do_kiedy'] AND $wynik_wypozyczenia['od_kiedy'] < $to_date){
                                $wypisz = false;
                                break;
                            }else{
                                $wypisz = true;
                            }
                        }
                    }
                    //WYJATEK KIEDY NIE MA ZADNYCH AUT WYPOZYCZONYCH
                    $wypozyczone = mysqli_query($baza, $select_wypozyczone) or die(mysqli_error($baza));
                    if(mysqli_fetch_array($wypozyczone) == NULL){
                        if($wynik_samochody['id_miejsca'] == $location){
                            $wypisz = true;
                        }
                    }
                    //WYPISYWANIE DOSTEPNYCH AUT
                    if($wypisz == true){
                        echo 
                        '
                        <form action="main.php" method="get">
                        <div class="card">
                            <img class="car-image" src='.$wynik_samochody['sciezka_zdjecia'].'>
                            <h3>'.$wynik_samochody['marka']." ".$wynik_samochody['model'].'</h3>
                            <div style="display:flex;">
                                <div class="icon">
                                    <p><i class="fa-solid fa-person" style="font-size: 120%;"></i>&nbsp; '.$wynik_samochody['ilosc_miejsc'].' seats</p>
                                    <p><i class="fa-solid fa-truck-ramp-box" style="font-size: 75%;"></i> '.$wynik_samochody['pojemnosc_bagaznika'].' liters</p>
                                    <p><i class="fa-solid fa-horse-head" style="font-size: 85%;"></i> '.$wynik_samochody['moc_silnika'].' hp</p>
                                </div>
                                <div class="icon">
                                    <p><i class="fa-solid fa-gas-pump"></i> '.$wynik_samochody['paliwo'].'</p>
                                    <p><i class="fa-solid fa-gears" style="font-size: 85%;"></i> '.$wynik_samochody['skrzynia_biegow'].'</p>
                                    <p><i class="fa-solid fa-calendar"></i> '.$wynik_samochody['rocznik'].'</p>
                                </div>
                            </div>

                            <p style="display: inline-block; font-size: 80%">for 1 day: &nbsp;</p>
                            <h4 style="display: inline-block"> '.$wynik_samochody['cena_wypozyczenie_doba'].' PLN</h4>
                            <br>
                            <button type="submit" name="id_selected_car" class="rent-button" value="'.$wynik_samochody['id_samochodu'].'">RENT</button>
                        </div>
                        </form>
                        ';
                    }
                }
            mysqli_close($baza);
            }

            //WYSWIELTANIE OKNA WYNAJMU WYBRANEGO AUTA
            if(isset($_GET['id_selected_car'])){
                //OBLICZANIE ROZNICY DAT
                $date1 = new DateTime($_SESSION['from_date']);;
                $date2 = new DateTime($_SESSION['to_date']);
            
                $date_diff = date_diff($date1, $date2) -> format('%a');

                $_SESSION['id_selected_car'] = $_GET['id_selected_car'];

                $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                $select_samochody = "SELECT id_samochodu, marka, model, ilosc_miejsc, pojemnosc_bagaznika, moc_silnika, paliwo, skrzynia_biegow, rocznik, cena_wypozyczenie_doba, id_miejsca, sciezka_zdjecia FROM samochody";
                $samochody = mysqli_query($baza, $select_samochody) or die(mysqli_error($baza));

                //WYSWIETLANIE OKNA WYNAJMU AUTA
                while($wynik_samochody = mysqli_fetch_array($samochody)){
                    if($_GET['id_selected_car'] == $wynik_samochody['id_samochodu']){
                        echo 
                        '
                        <div class="rent-card">
                            <img class="rent-card-car-image" src='.$wynik_samochody['sciezka_zdjecia'].'>
                            <h3>'.$wynik_samochody['marka'].' '.$wynik_samochody['model'].'</h3>
                            <h4 style="opacity:0.8; margin-bottom: 10px;">'.$_SESSION['from_date'].' to '.$_SESSION['to_date'].'<br>Location: '.$_SESSION['locations_names'][$_SESSION['location']].'</h4>
                            <p style="display: inline-block; color: gray; margin: 10px 0 20px;">Price:</p>
                            <h4 style="display: inline-block; margin: 10px 0 20px;"> '.($wynik_samochody['cena_wypozyczenie_doba']*$date_diff).' PLN</h4>
                            <p style="display: inline-block; color: gray; margin: 10px 0 20px;">for '.$date_diff.' days</p>
                            <form method="post" action="main.php">
                                <input type="text" name="first-name" id="first-name" placeholder="First Name" class="name-input" required><br>
                                <input type="text" name="second-name" id="second-name" placeholder="Second Name" class="name-input" required><br>
                                <input type="tel" name="telephone" id="telephone" placeholder="Tel nr (ex. 123456789)" class="name-input" pattern="[0-9]{9}" required><br>
                                <input type="submit" value="Order" id="submit-but" style="margin-top: 10px; width: 100px"></input>
                            </form>
                        </div>
                        ';
                    }
                }
            
                mysqli_close($baza);
            }

            //
            if(isset($_POST['first-name'])){
                $first_name = $_POST['first-name'];
                $second_name = $_POST['second-name'];
                $telephone = $_POST['telephone'];
                $car_id = $_SESSION['id_selected_car'];
                $from_date = $_SESSION['from_date'];
                $to_date = $_SESSION['to_date'];
                
                $client_id = "NULL";

                $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                
                //SPRAWDZANIE CZY ISTNIEJE JUZ UZYTKOWNIK O TAKIM IMIENIU I NAZWISKU
                $select_klienci = "SELECT `id_klienta`, `prof`, `imie`, `nazwisko`, `telefon` FROM klienci";
                $klienci = mysqli_query($baza, $select_klienci) or die(mysqli_error($baza));

                while($wynik_klienci = mysqli_fetch_array($klienci)){
                    if($wynik_klienci['imie'] == $first_name AND $wynik_klienci['nazwisko'] == $second_name AND $wynik_klienci['telefon'] == $telephone){
                        $client_id = $wynik_klienci['id_klienta'];
                        break;
                    } 
                }
                //DODAWANIE KLIENTA DO TABLICY klienci
                if($client_id == "NULL"){
                    $insert_klienci = "INSERT INTO klienci(id_klienta, prof, imie, nazwisko, telefon) VALUES ('NULL', 'zdjecia/user.jpg', '$first_name', '$second_name', '$telephone')";
                    mysqli_query($baza, $insert_klienci) or die(mysqli_error($baza));

                    $select_id_klienta = "SELECT `id_klienta`,`prof`, `imie`, `nazwisko`, `telefon` FROM klienci";
                    $klienci = mysqli_query($baza, $select_id_klienta) or die(mysqli_error($baza));

                    while($wynik_klienci = mysqli_fetch_array($klienci)){
                        if($wynik_klienci['imie'] == $first_name AND $wynik_klienci['nazwisko'] == $second_name AND $wynik_klienci['telefon'] == $telephone){
                            $client_id = $wynik_klienci['id_klienta'];
                        }
                    }
                }
                

                //WPISYWANIE DO TABELI wypozyczenie
                $insert_wypozyczone = "INSERT INTO wypozyczenie(id_wypozyczenia, id_klienta, id_samochodu, od_kiedy, do_kiedy) VALUES ('NULL', '$client_id', '$car_id', '$from_date','$to_date')";
                mysqli_query($baza, $insert_wypozyczone) or die(mysqli_error($baza));

                mysqli_close($baza);
            }
        ?>
    </div>
    

    <script>

        //ZBIERANIE DANYCH Z FORMULARZA
        const login_icon = document.querySelector("#login_icon");
        const pop_up_login_form = document.getElementById("pop_up_login_form");
        let if_visible = false;
 

        login_icon.addEventListener('click', function(){
            if(if_visible == false){
                pop_up_login_form.style.visibility = "visible";
                pop_up_login_form.classList.remove("pop_up_hide");
                pop_up_login_form.classList.add("pop_up_show");
            }else{
                pop_up_login_form.classList.remove("pop_up_show");
                pop_up_login_form.classList.add("pop_up_hide");
                
                
            }
            if_visible = !if_visible;
        });

        //DRUGA DATA WIEKSZA OD PIERWSZEJ
        const first_date = document.querySelector("#from-date");
        const second_date = document.querySelector("#to-date");

        first_date.addEventListener('change', function(){
            var min_date = first_date.value;

            second_date.min = addOneDay(min_date);
        })

        function addOneDay(date){
            copy_date = new Date(date);
            copy_date.setDate(copy_date.getDate() + 1);
            copy_date = copy_date.toISOString();
            copy_date = copy_date.split('T');

            return copy_date[0];
        }

        //PIERWSZA DATA WIEKSZA OD AKTUALNEJ
        copy_date = new Date();
        copy_date = copy_date.toISOString();
        copy_date = copy_date.split('T');

        first_date.min = copy_date[0];
    </script>
</body>
</html>