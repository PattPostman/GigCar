DROP DATABASE IF EXISTS baza_wypozyczalnii;
CREATE DATABASE baza_wypozyczalnii;
USE baza_wypozyczalnii;

    create table samochody(
        id_samochodu int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        marka text NOT NULL,
        model text NOT NULL,
        ilosc_miejsc int NOT NULL,
        pojemnosc_bagaznika int NOT NULL,
        moc_silnika int NOT NULL,
        paliwo text NOT NULL,
        skrzynia_biegow text NOT NULL,
        rocznik int NOT NULL,
        cena_wypozyczenie_doba int NOT NULL,
        id_miejsca int(2) UNSIGNED NOT NULL,
        sciezka_zdjecia text NOT NULL,
        PRIMARY KEY (id_samochodu)
    );
    
    INSERT INTO samochody VALUES (NULL, "Kia", "Rio", 5, 40, 80, "diesel", "manual", 2016, 220, 1, "zdjecia/auto1.png");
    INSERT INTO samochody VALUES (NULL, "Volkswagen", "Polo", 5, 35, 103, "diesel", "manual", 2018, 350, 1, "zdjecia/auto2.png");
    INSERT INTO samochody VALUES (NULL, "Smart", "ForFour", 4, 20, 54, "petrol", "manual", 2020, 180, 1, "zdjecia/auto3.png");
    INSERT INTO samochody VALUES (NULL, "Volkswagen", "Golf", 5, 38, 121, "diesel", "manual", 2017, 175, 1, "zdjecia/auto4.png");
    INSERT INTO samochody VALUES (NULL, "Ford", "Fiesta", 5, 40, 76, "petrol", "manual", 2016, 162, 1, "zdjecia/auto5.png");
    INSERT INTO samochody VALUES (NULL, "Nissan", "Qashqai", 5, 50, 154, "petrol", "manual", 2019, 332, 1, "zdjecia/auto6.png");
    INSERT INTO samochody VALUES (NULL, "Kia", "Stonic", 4, 20, 95, "petrol", "manual", 2015, 303, 2, "zdjecia/auto7.png");
    INSERT INTO samochody VALUES (NULL, "Renault", "Kadjar", 5, 50, 127, "petrol", "automatic", 2019, 365, 2, "zdjecia/auto8.png");
    INSERT INTO samochody VALUES (NULL, "Kia", "Picanto", 4, 25, 65, "petrol", "manual", 2018, 231, 2, "zdjecia/auto9.png");
    INSERT INTO samochody VALUES (NULL, "Nissan", "Juke", 5, 35, 94, "petrol", "automatic", 2020, 332, 2, "zdjecia/auto10.png");
    INSERT INTO samochody VALUES (NULL, "Renault", "Clio", 5, 60, 160, "petrol", "manual", 2021, 233, 2, "zdjecia/auto11.png");
    INSERT INTO samochody VALUES (NULL, "Opel", "Astra", 5, 50, 120, "diesel", "manual", 2016, 289, 2, "zdjecia/auto12.png");
    INSERT INTO samochody VALUES (NULL, "Fiat", "500", 4, 35, 86, "diesel", "manual", 2015, 307, 3, "zdjecia/auto13.png");
    INSERT INTO samochody VALUES (NULL, "Toyota", "Corolla", 5, 60, 141, "petrol", "manual", 2016, 332, 3, "zdjecia/auto14.png");
    INSERT INTO samochody VALUES (NULL, "Toyota", "Aygo", 5, 30, 75, "petrol", "manual", 2018, 248, 3, "zdjecia/auto15.png");
    INSERT INTO samochody VALUES (NULL, "Ford", "Focus", 5, 70, 180, "diesel", "manual", 2015, 245, 3, "zdjecia/auto16.png");
    INSERT INTO samochody VALUES (NULL, "Hyundai", "i30", 5, 40, 77, "petrol", "manual", 2021, 305, 3, "zdjecia/auto17.png");
    INSERT INTO samochody VALUES (NULL, "Toyota", "Yaris", 5, 45, 86, "petrol", "automatic", 2017, 357, 3, "zdjecia/auto18.png");
    INSERT INTO samochody VALUES (NULL, "Volkswagen", "Tiguan", 5, 60, 147, "diesel", "manual", 2019, 404, 4, "zdjecia/auto19.png");
    INSERT INTO samochody VALUES (NULL, "Skoda", "Fabia", 5, 45, 79, "petrol", "automatic", 2020, 302, 4, "zdjecia/auto20.png");
    INSERT INTO samochody VALUES (NULL, "Skoda", "Fabia Estate", 5, 65, 108, "petrol", "manual", 2019, 333, 4, "zdjecia/auto21.png");
    INSERT INTO samochody VALUES (NULL, "Opel", "Vauxhall Astra", 5, 57, 102, "diesel", "manual", 2016, 326, 4, "zdjecia/auto22.png");
    INSERT INTO samochody VALUES (NULL, "Audi", "A3", 5, 40, 250, "diesel", "manual", 2018, 294, 4, "zdjecia/auto23.png");
    INSERT INTO samochody VALUES (NULL, "Kia", "Ceed Estate", 5, 65, 150, "petrol", "manual", 2019, 312, 4, "zdjecia/auto24.png");
    INSERT INTO samochody VALUES (NULL, "Seat", "Leon", 5, 50, 137, "diesel", "automatic", 2022, 352, 5, "zdjecia/auto25.png");
    INSERT INTO samochody VALUES (NULL, "Mercedes-Benz", "GLC", 5, 80, 276, "petrol", "automatic", 2020, 1130, 5, "zdjecia/auto26.png");
    INSERT INTO samochody VALUES (NULL, "Audi", "A6", 5, 50, 300, "petrol", "automatic", 2019, 1247, 5, "zdjecia/auto27.png");
    INSERT INTO samochody VALUES (NULL, "Audi", "Q5", 5, 70, 260, "diesel", "automatic", 2018, 1373, 5, "zdjecia/auto28.png");
    INSERT INTO samochody VALUES (NULL, "Audi", "A4", 5, 45, 350, "diesel", "automatic", 2017, 1132, 5, "zdjecia/auto29.png");
    INSERT INTO samochody VALUES (NULL, "BMW", "3 Series", 5, 45, 420, "petrol", "automatic", 2020, 1200, 5, "zdjecia/auto30.png");

    
    create table miejsca_pobytu(
        id_miejsca int(2) UNSIGNED not NULL AUTO_INCREMENT,
        nazwa_miasta text NOT NULL,
        PRIMARY KEY (id_miejsca)
    );

    INSERT INTO miejsca_pobytu (nazwa_miasta) VALUES ("Warsaw");
    INSERT INTO miejsca_pobytu (nazwa_miasta) VALUES ("Cracow");
    INSERT INTO miejsca_pobytu (nazwa_miasta) VALUES ("Rome");
    INSERT INTO miejsca_pobytu (nazwa_miasta) VALUES ("Berlin");
    INSERT INTO miejsca_pobytu (nazwa_miasta) VALUES ("Paris");

    create table klienci(
        id_klienta int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        prof text not NULL,
        imie text NOT NULL,
        nazwisko text NOT NULL,
        telefon int(9),
        PRIMARY KEY (id_klienta)
    );

    INSERT INTO klienci VALUES (NULL,"zdjecia/user.jpg" ,"Jan", "Mojsa", 123456789);
    INSERT INTO klienci VALUES (NULL,"zdjecia/user.jpg" ,"Jakub", "Przybylinski", 987654321);
    INSERT INTO klienci VALUES (NULL,"zdjecia/user.jpg" ,"Antoni", "Lyzwa", 789456123);

    create table wypozyczenie(
        id_wypozyczenia int(10) UNSIGNED not NULL AUTO_INCREMENT,
        id_klienta int(10) UNSIGNED not NULL,
        id_samochodu int (10) UNSIGNED not NULL,
        od_kiedy date,
        do_kiedy date,
        PRIMARY KEY (id_wypozyczenia)
    );

    INSERT INTO wypozyczenie VALUES (NULL, 1, 1, '2019-12-31', '2023-12-31');
    INSERT INTO wypozyczenie VALUES (NULL, 1, 2, '2019-12-31', '2023-12-31');
    INSERT INTO wypozyczenie VALUES (NULL, 1, 3, '2019-12-31', '2023-12-31');

    
    create table dane_logowania(
        login text not NULL,
        haslo text not NULL
    );

    INSERT INTO dane_logowania VALUES ("admin", "admin");

    ALTER TABLE samochody ADD FOREIGN KEY (id_miejsca) REFERENCES miejsca_pobytu(id_miejsca);
    ALTER TABLE wypozyczenie ADD FOREIGN KEY (id_klienta) REFERENCES klienci(id_klienta);
    ALTER TABLE wypozyczenie ADD FOREIGN KEY (id_samochodu) REFERENCES samochody(id_samochodu);

    CREATE USER IF NOT EXISTS 'antek'@'localhost' IDENTIFIED BY '1234';
    GRANT SELECT, INSERT, UPDATE, DELETE ON baza_wypozyczalnii.* TO antek@localhost; 

    DROP VIEW IF EXISTS wypozyczenie_view;

