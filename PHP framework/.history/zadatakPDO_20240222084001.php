<?php
require 'vendor/autoload.php';
use Controllers\IndexController;
use Controllers\KorisnikController;
use Database\Connection;
use Classes\Korisnik;



// kreiranje korisnika
// parametri: ime, spol (M ili Ž), dob
// opcionalni parametar: id (služi kod update metode)ž
$korisnik = new Korisnik("Robert", "M", 50);

// save korisnika
$result = $korisnik->save();

// update korisnika
// try {
//    $id = 50;
//    $korisnik = Korisnik::find($id);
//    $korisnik->attributes = ['id' => $id];
//    $korisnik->setIme("Pete");
//    $korisnik->setSpol("M");
//    $korisnik->setDob(45);
//    $result = $korisnik->update();
//    print_r($korisnik);
// } catch (Exception $e) {
//    echo $e->getMessage();
// }


// try {
//    $id = 35;
//    $korisnik = Korisnik::find($id);
//    print_r($korisnik);
// } catch (Exception $e) {
//    echo $e->getMessage();
// }


// find($primaryKey)
// try {
//    $id = 35;
//    $korisnik = Korisnik::find($id);
//    print_r($korisnik);
// } catch (Exception $e) {
//    echo $e->getMessage();
// }

// toArray()
// print_r($korisnik->toArray());

// delete korisnika
// try {
//    $id = 35;
//    $korisnik = new Korisnik();
//    $korisnik = Korisnik::find($id);
//    $korisnik->attributes = ['id' => $id];
//    $korisnik->delete();
// } catch (Exception $e) {
//    echo $e->getMessage();
// }