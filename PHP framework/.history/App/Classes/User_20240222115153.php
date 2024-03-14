<?php
namespace Classes;
use Database\Model;
use Classes\TimestampCreate;
use Classes\TimestampDelete;
class User extends Model {
    use TimestampCreate;
    use TimestampDelete;
    protected $table = 'korisnici';
    public $ime;
    public $spol;
    public $dob;

    public function setName($name) {
        $this->ime = $name;
        $this->attributes['name'] = $name;
    }
    public function setSpol($spol) {
        $this->spol = $spol;
        $this->attributes['spol'] = $spol;
    }
    public function setDob($dob) {
        $this->dob = $dob;
        $this->attributes['dob'] = $dob;
    }

    public function __construct(string $ime, string $spol, int $dob = null) {
        $this->attributes = [
            'ime' => $ime,
            'spol' => $spol,
            'dob' => $dob
        ];
   
        // provjera ako klasa koristi timestampove
        $classTraits = class_uses(get_class($this));
        if (isset($classTraits[TimestampCreate::class])) {
            TimestampCreate::setTimestamp($this);
        }
    }

    public function update() {
        // provjera ako klasa koristi timestampove
        $classTraits = class_uses(get_class($this));
        if (isset($classTraits[TimestampCreate::class])) {
            TimestampCreate::updateTimestamp($this);
        }
        Model::update();
    }

    public function delete() {
        // provjera ako klasa koristi timestampove
        $classTraits = class_uses(get_class($this));
        if (isset($classTraits[TimestampDelete::class])) {
            TimestampDelete::softDelete($this);
            Model::update();
        } else {
            Model::delete();
        }
    }
}