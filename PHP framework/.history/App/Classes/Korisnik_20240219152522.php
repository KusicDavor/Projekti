<?php 
namespace Classes;
class Korisnik extends Model {
    protected $table = 'korisnici';

    public $ime;
    public $spol;
    public $dob;
}