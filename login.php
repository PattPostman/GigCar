<?php
    session_start();
    if(!isset($_POST['login']) AND !isset($_POST['password'])){
        header("Location: main.php");
        exit();
    }else{
        $entered_login = $_POST['login'];
        $entered_password = $_POST['password'];
        $_SESSION['zalogowany'] = 0;
        $baza = mysqli_connect('localhost', 'antek', '1234', 'baza_wypozyczalnii');

        $select_dane_logowania = "SELECT * FROM dane_logowania";
        $dane_logowania = mysqli_query($baza, $select_dane_logowania) or die(mysqli_error($baza));

        while($wyniki = mysqli_fetch_array($dane_logowania)){
            $_SESSION['login'] = $wyniki['login'];
            if($wyniki['login'] == $entered_login AND $wyniki['haslo'] == $entered_password){
                $_SESSION['zalogowany'] = 1;
                header("Location: managment.php");
                exit();
            }
        }
    }
    header("Location: main.php");
    exit();
    mysqli_close($baza);
?>