<?php
namespace Classes;
use Database\Connection;
trait Timestamp {
    public static function setTimestamps() {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}