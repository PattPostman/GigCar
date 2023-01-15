<?php
    session_start(); 

    //SPRAWDZANIE LOGOWANIA DO ADMINA
    if(!isset($_SESSION['zalogowany']) OR $_SESSION['zalogowany'] == 0){
        header("Location: main.php");
        exit();
    }
    //WYLOGOWANIE SIE
    if(isset($_POST['log-out'])){
        header("Location: main.php");
        $_SESSION['zalogowany'] = 0;
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Rent</title>
     <!--Css-->
    <link rel="stylesheet" href="managment_style.css">
    <!--Icons-->
    <script src="https://kit.fontawesome.com/7d12fad211.js" crossorigin="anonymous"></script>
    <!--Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
</head>
<body>

    <div id="nav_managment">
        <a href="main.php"><img id="logo_managment" src="zdjecia/black_logo.JPG"></a>
        <div class="select_win" id="window_1">ADD NEW CAR</div>
        <div class="select_win" id="window_2">ADD NEW<br>LOCATION</div>
        <div class="select_win" id="window_3">CHECK ORDERS</div>
        <div class="select_win" id="window_4">CARS BASE</div>
        <div class="select_win" id="window_5">CUSTOMERS BASE</div>
        <div class="select_win" id="window_6">LOCATIONS BASE</div>
        <form method="post" class="select_win">
            <input type="submit" name="log-out" value="LOG OUT" class="log_out_but">
        </form>
    </div>
    <div id="main">
        <!--ADD NEW CAR-->
        <form method="post" action="adding_to_database.php">
            <div id="add_new_car" class="background_of_element">
                <h2 style="color:white; text-align:center;">ADDING NEW CAR</h2>
                <div class="add_new_car_rows">
                    <div class="field_input_h3">
                        <h3>Brand</h3>
                        <input type="text" name="brand" placeholder="Kia" class="input_text" required>
                    </div>
                    <div class="field_input_h3">
                        <h3>Model</h3>
                        <input type="text" name="model" placeholder="Rio" class="input_text" required>
                    </div>
                </div>
                <div class="add_new_car_rows">
                    <div class="field_input_h3">
                        <h3>No. seats</h3>
                        <input type="number" name="seats" placeholder="5" min="1" max="9" class="input_text" required>
                    </div>
                    <div class="field_input_h3">
                        <h3>Trunk capacity</h3>
                        <input type="number" name="trunk" placeholder="40L" min="1" class="input_text" required>
                    </div>
                    <div class="field_input_h3">
                        <h3>Power</h3>
                        <input type="number" name="power" placeholder="80KM" min="1" class="input_text" required>
                    </div>
                </div>
                <div class="add_new_car_rows">
                    <div class="field_input_h3">
                        <h3>Type of fuel</h3>
                        <select name="fuel" class="input_text"required>
                            <option value="diesel">Diesel</option>
                            <option value="petrol">Petrol</option> 
                        </select>
                    </div>
                    <div class="field_input_h3">
                        <h3>Transmission</h3>
                        <select name="gearbox" class="input_text" required>
                            <option value="manual">Manual</option>
                            <option value="automatic">Automatic</option>
                        </select>
                    </div>
                    <div class="field_input_h3">
                        <h3>Year</h3>
                        <input type="number" name="year" placeholder="2016" min="1900" max="2050" class="input_text" required>
                    </div>
                </div>
                <div class="add_new_car_rows">
                    <div class="field_input_h3">
                        <h3>Price per day</h3>
                        <input type="number" name="price" placeholder="220PLN" min="1" class="input_text" required>
                    </div>
                    <div class="field_input_h3">
                        <h3>Location</h3>
                        <select name="location" class="input_text">
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
                        </select>
                    </div>
                    <div class="field_input_h3">
                        <h3>Photo path</h3>
                        <input type="text" name="photo_path" placeholder="zdjecia/auto1.png" class="input_text" required>
                    </div>
                </div>
                <div class="add_new_car_rows">
                    <input type="submit" value="ADD" class="input_submit">
                </div>
            </div>
        </form>
        <!--ERROR MESSAGE-->
        <div id="failed_delete_car" class="background_of_element">
            <h2 style="color:white; text-align:center;">FAILED TO DELETE CAR</h2>
            <div class="add_new_car_rows">
                <div class="field_input_h3" style="width:100%">
                    <h3>Delete all orders related to this car</h3>
                </div>
            </div>
            <div class="add_new_car_rows">
                <input type="button" value="CLOSE" class="input_submit" id="failed_delete_car_ok_but">
            </div>
         </div>
        <!--ADD NEW LOCATION-->
        <form method="post" action="adding_to_database.php">
            <div id="add_new_location" class="background_of_element">
                <h2 style="color:white; text-align:center;">ADDING NEW LOCATION</h2>
                <div class="add_new_car_rows">
                    <div class="field_input_h3" style="width:100%">
                        <h3>Location name</h3>
                        <input type="text" name="new_location" placeholder="Warsaw" class="input_text" required>
                    </div>
                </div>
                <div class="add_new_car_rows">
                    <input type="submit" value="ADD" class="input_submit">
                </div>
            </div>
        </form>
        <!--CHECK ORDERS-->
            <div id="check_orders">
            <?php
                        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                        $select_orders = "SELECT wypozyczenie.id_wypozyczenia, klienci.id_klienta, klienci.imie, klienci.nazwisko, klienci.telefon, wypozyczenie.id_wypozyczenia, wypozyczenie.od_kiedy, wypozyczenie.do_kiedy, samochody.marka, samochody.model,  samochody.rocznik, miejsca_pobytu.nazwa_miasta
                        FROM wypozyczenie
                        INNER JOIN klienci
                        ON wypozyczenie.id_klienta = klienci.id_klienta
                        INNER JOIN samochody
                        ON wypozyczenie.id_samochodu = samochody.id_samochodu
                        INNER JOIN miejsca_pobytu
                        ON samochody.id_miejsca = miejsca_pobytu.id_miejsca";
                        $orders = mysqli_query($baza, $select_orders) or die(mysqli_error($baza));
                        while ($wynik_orders = mysqli_fetch_array($orders)) {
                            echo'<div class="card">
                            <form action="adding_to_database.php" method="post">
                            <h4>Order nr.'.$wynik_orders['id_wypozyczenia'].'</h4><br>
                            <b>Client:</b> ' . $wynik_orders['imie'] . " " . $wynik_orders['nazwisko'] .  " <br> <b>Phone nubmer: </b>" . $wynik_orders['telefon'] . " <br><b>Pick up place:</b> " . $wynik_orders['nazwa_miasta'] ." <br><b>Car:</b> " . $wynik_orders['marka'] . " " .$wynik_orders['model'] . " " . $wynik_orders['rocznik'] . " <br><b>From: </b>" . $wynik_orders['od_kiedy'] . " &emsp; <b>To:</b> " . $wynik_orders['do_kiedy'] .'
                            <br><br><button type="submit" name="id_delete_order" class="delete-order" value="' . $wynik_orders['id_wypozyczenia'] . '">DELETE</button>
                            </form></div>';}
                        mysqli_close($baza);
                        ?>
            </div>
        <!--CAR BASE-->
            <div id="car_base">
                        <?php
                        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                        $select_samochody = "SELECT id_samochodu, marka, model, ilosc_miejsc, pojemnosc_bagaznika, moc_silnika, paliwo, skrzynia_biegow, rocznik, cena_wypozyczenie_doba, id_miejsca, sciezka_zdjecia FROM samochody";
                        $samochody = mysqli_query($baza, $select_samochody) or die(mysqli_error($baza));
                        while ($wynik_samochody = mysqli_fetch_array($samochody)) {
                            echo'<form action="adding_to_database.php" method="post">
                            <div class="card">
                            <img class="car-image" src=' . $wynik_samochody['sciezka_zdjecia'] . '>
                            <h3>' . $wynik_samochody['marka'] . " " . $wynik_samochody['model'] . '</h3>
                            <div style="display:flex;">
                                <div class="icon">
                                    <p><i class="fa-solid fa-person" style="font-size: 120%;"></i>&nbsp; ' . $wynik_samochody['ilosc_miejsc'] . ' seats</p>
                                    <p><i class="fa-solid fa-truck-ramp-box" style="font-size: 75%;"></i> ' . $wynik_samochody['pojemnosc_bagaznika'] . ' liters</p>
                                    <p><i class="fa-solid fa-horse-head" style="font-size: 85%;"></i> ' . $wynik_samochody['moc_silnika'] . ' hp</p>
                                </div>
                                <div class="icon">
                                    <p><i class="fa-solid fa-gas-pump"></i> ' . $wynik_samochody['paliwo'] . '</p>
                                    <p><i class="fa-solid fa-gears" style="font-size: 85%;"></i> ' . $wynik_samochody['skrzynia_biegow'] . '</p>
                                    <p><i class="fa-solid fa-calendar"></i> ' . $wynik_samochody['rocznik'] . '</p>
                                </div>
                            </div>
                            <p style="display: inline-block; font-size: 80%">for 1 day: &nbsp;</p>
                            <h4 style="display: inline-block"> ' . $wynik_samochody['cena_wypozyczenie_doba'] . ' PLN</h4>
                            <br>
                            <button type="submit" name="id_delete_car" class="delete-button" value="' . $wynik_samochody['id_samochodu'] . '">DELETE</button>
                            </div>
                            </form>';}
                        mysqli_close($baza);
                        ?>
            </div>
        <!--CUSTOMER BASE-->
            <div id="customer_base">
            <?php
                        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                        $select_customers = "SELECT `id_klienta`, `prof`, `imie`, `nazwisko`, `telefon` FROM `klienci`";
                        $customers = mysqli_query($baza, $select_customers) or die(mysqli_error($baza));
                        while ($wynik_customers = mysqli_fetch_array($customers)) {
                            echo'<div class="card">
                            <img class="customer-image" src=' . $wynik_customers['prof'] . '>
                            <h3>' . $wynik_customers['imie'] . ' <br> ' . $wynik_customers['nazwisko'] . '</h3>
                            <h4>Telefon: ' . $wynik_customers['telefon'] . '</h4>
                            </div>';}
                        mysqli_close($baza);
                        ?>
            </div>
        <!--LOCATION BASE-->
            <div id="location_base">
            <?php
                        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
                        $select_place = "SELECT `id_miejsca`, `nazwa_miasta` FROM `miejsca_pobytu`";
                        $place = mysqli_query($baza, $select_place) or die(mysqli_error($baza));
                        echo '<h3>Places we cover: 
                        <ul>';
                        while ($wynik_place = mysqli_fetch_array($place)) {
                            echo
                                '<li><h4>' . $wynik_place['nazwa_miasta'] . '</h4></li>';}
                        echo '</ul>';
                        mysqli_close($baza);
                        ?>
            </div>
        
    </div>
    <?php
        //SPRAWDZANIE CZY UDALO SIE USUNAC AUTO
        if(isset($_SESSION['nie_usunieto_auta'])){
            if($_SESSION['nie_usunieto_auta']){
                echo'
                <script type="text/JavaScript">
                    nie_usunieto_auta = 1;
                </script>
                ';
                $_SESSION['nie_usunieto_auta'] = 0;
            }
        }
    ?>
    <script>
        const win_1 = document.querySelector('#window_1');
        const win_2 = document.querySelector('#window_2');
        const win_3 = document.querySelector('#window_3');
        const win_4 = document.querySelector('#window_4');
        const win_5 = document.querySelector('#window_5');
        const win_6 = document.querySelector('#window_6');
        const add_new_car = document.querySelector('#add_new_car');
        const add_new_location = document.querySelector('#add_new_location');
        const check_orders = document.querySelector('#check_orders');
        const car_base = document.querySelector('#car_base');
        const customer_base = document.querySelector('#customer_base');
        const location_base = document.querySelector('#location_base');

        const failed_delete_car = document.querySelector('#failed_delete_car');
        const failed_delete_car_ok_but = document.querySelector('#failed_delete_car_ok_but');

        failed_delete_car_ok_but.addEventListener('click', function(){
            failed_delete_car.style.display = "none";
        })
        if (typeof nie_usunieto_auta === 'undefined'){
            nie_usunieto_auta = 0;
        }
        if(nie_usunieto_auta){
            failed_delete_car.style.display = "block";
        }

        win_1.addEventListener('click', function(){

            add_new_car.style.display = "none";
            add_new_location.style.display = "none";
            check_orders.style.display = "none";
            car_base.style.display = "none";
            customer_base.style.display = "none";
            location_base.style.display = "none";

            failed_delete_car.style.display = "none";

            add_new_car.style.display = "block";


            win_1.classList.add("select_win_js");
            win_2.classList.remove("select_win_js");
            win_3.classList.remove("select_win_js");
            win_4.classList.remove("select_win_js");
            win_5.classList.remove("select_win_js");
            win_6.classList.remove("select_win_js");
        })
        win_2.addEventListener('click', function(){

            add_new_car.style.display = "none";
            add_new_location.style.display = "none";
            check_orders.style.display = "none";
            car_base.style.display = "none";
            customer_base.style.display = "none";
            location_base.style.display = "none";

            failed_delete_car.style.display = "none";

            add_new_location.style.display = "block";

            win_1.classList.remove("select_win_js");
            win_2.classList.add("select_win_js");
            win_3.classList.remove("select_win_js");
            win_4.classList.remove("select_win_js");
            win_5.classList.remove("select_win_js");
            win_6.classList.remove("select_win_js");
        })
        win_3.addEventListener('click', function(){
            
            add_new_car.style.display = "none";
            add_new_location.style.display = "none";
            check_orders.style.display = "none";
            car_base.style.display = "none";
            customer_base.style.display = "none";
            location_base.style.display = "none";

            failed_delete_car.style.display = "none";

            check_orders.style.display = "flex";

            win_1.classList.remove("select_win_js");
            win_2.classList.remove("select_win_js");
            win_3.classList.add("select_win_js");
            win_4.classList.remove("select_win_js");
            win_5.classList.remove("select_win_js");
            win_6.classList.remove("select_win_js");
        })
        win_4.addEventListener('click', function(){
            
            add_new_car.style.display = "none";
            add_new_location.style.display = "none";
            check_orders.style.display = "none";
            car_base.style.display = "none";
            customer_base.style.display = "none";
            location_base.style.display = "none";

            failed_delete_car.style.display = "none";

            car_base.style.display = "flex";

            win_1.classList.remove("select_win_js");
            win_2.classList.remove("select_win_js");
            win_3.classList.remove("select_win_js");
            win_4.classList.add("select_win_js");
            win_5.classList.remove("select_win_js");
            win_6.classList.remove("select_win_js");
        })
        win_5.addEventListener('click', function(){
            
            add_new_car.style.display = "none";
            add_new_location.style.display = "none";
            check_orders.style.display = "none";
            car_base.style.display = "none";
            customer_base.style.display = "none";
            location_base.style.display = "none";

            failed_delete_car.style.display = "none";

            customer_base.style.display = "flex";

            win_1.classList.remove("select_win_js");
            win_2.classList.remove("select_win_js");
            win_3.classList.remove("select_win_js");
            win_4.classList.remove("select_win_js");
            win_5.classList.add("select_win_js");
            win_6.classList.remove("select_win_js");
        })
        win_6.addEventListener('click', function(){
            
            add_new_car.style.display = "none";
            add_new_location.style.display = "none";
            check_orders.style.display = "none";
            car_base.style.display = "none";
            customer_base.style.display = "none";
            location_base.style.display = "none";

            failed_delete_car.style.display = "none";

            location_base.style.display = "block";

            win_1.classList.remove("select_win_js");
            win_2.classList.remove("select_win_js");
            win_3.classList.remove("select_win_js");
            win_4.classList.remove("select_win_js");
            win_5.classList.remove("select_win_js");
            win_6.classList.add("select_win_js");
        })


    </script>
</body>
</html>