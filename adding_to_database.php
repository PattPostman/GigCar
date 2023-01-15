<?php
    //DANE LOGOWANIA ('localhost','antek','1234','id20112617_baza_wypozyczalnii') 

    session_start();
    if(!isset($_POST)){
        header("Location: managment.php");
        exit();
    }


    //DODAWANIE AUTA DO BAZY
    if(isset($_POST['brand'])){
        $marka = $_POST['brand'];
        $model = $_POST['model'];
        $ilosc_miejsc = $_POST['seats'];
        $pojemnosc_bagaznika = $_POST['trunk'];
        $moc_silnika = $_POST['power'];
        $paliwo = $_POST['fuel'];
        $skrzynia_biegow = $_POST['gearbox'];
        $rocznik = $_POST['year'];
        $cena_wypozyczenie_doba = $_POST['price'];
        $id_miejsca = $_POST['location'];
        $sciezka_zdjecia = $_POST['photo_path'];

        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
        $insert_auta = "INSERT INTO `samochody`(`id_samochodu`, `marka`, `model`, `ilosc_miejsc`, `pojemnosc_bagaznika`, `moc_silnika`, `paliwo`, `skrzynia_biegow`, `rocznik`, `cena_wypozyczenie_doba`, `id_miejsca`, `sciezka_zdjecia`) 
        VALUES ('NULL', '$marka', '$model', '$ilosc_miejsc', '$pojemnosc_bagaznika', '$moc_silnika', '$paliwo', '$skrzynia_biegow', '$rocznik', '$cena_wypozyczenie_doba', '$id_miejsca', '$sciezka_zdjecia')";
        mysqli_query($baza, $insert_auta) or die(mysqli_error($baza));  

        mysqli_close($baza);
        header("Location: managment.php");
        exit();
    }

    //DODAWANIE NOWEJ LOKALIZACJI DO BAZY
    if(isset($_POST['new_location'])){
        $new_location = $_POST['new_location'];

        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
        $insert_miejsca = "INSERT INTO `miejsca_pobytu`(`id_miejsca`, `nazwa_miasta`) VALUES ('NULL','$new_location')";

        mysqli_query($baza, $insert_miejsca) or die(mysqli_error($baza));  

        mysqli_close($baza);
        header("Location: managment.php");
        exit();

    }

    //USUWANIE SAMOCHODOW Z BAZY
    if(isset($_POST['id_delete_car'])){
        $_SESSION["nie_usunieto_auta"] = 0;
        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
        $delete_samochody = "DELETE FROM `samochody` WHERE `id_samochodu` LIKE ".$_POST['id_delete_car'];
        mysqli_query($baza, $delete_samochody) or $_SESSION['nie_usunieto_auta'] = 1;
        mysqli_close($baza);
        header("Location: managment.php");
        exit();
    }
    
    //USUWANIE ZLECEN Z BAZY
    if(isset($_POST['id_delete_order'])){
        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');
        $delete_wypozyczenie = "DELETE FROM `wypozyczenie` WHERE `id_wypozyczenia` LIKE ".$_POST['id_delete_order'];
        $wypozyczenie = mysqli_query($baza, $delete_wypozyczenie) or die(mysqli_error($baza));
        mysqli_close($baza);
        header("Location: managment.php");
        exit();
    }
?>