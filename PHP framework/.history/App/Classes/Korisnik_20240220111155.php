<?php
namespace Classes;
use Database\Model;
class Korisnik extends Model {
    use Timestamp;
    protected $table = 'korisnici';
    public $ime;
    public $spol;
    public $dob;
    public $created_at;
    public $updated_at;

    public function __construct(string $ime, string $spol, int $dob, ?int $id = null) {
        $this->attributes= [
                'ime' => $ime,
                'spol' => $spol,
                'dob' => $dob
             ];
             if ($id !== null) {
                $this->attributes['id'] = $id;
            }
        self::setTimestamps();
    }
}