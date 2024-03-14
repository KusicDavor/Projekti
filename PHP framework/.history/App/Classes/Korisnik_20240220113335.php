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
        echo ""
        $this->attributes= [
                'ime' => $this->$ime,
                'spol' => $this->$spol,
                'dob' => $this->$dob
             ];

        if ($id !== null) {
            $this->attributes['id'] = $this->$id;
        }

        if (in_array(Timestamp::class, class_uses($this))) {
            echo "da";
            self::setTimestamps();
            $this->attributes = [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ];
        }
    }
}