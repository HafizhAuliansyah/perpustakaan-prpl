<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
 
class BukuHelper {
    static $increment_id = -1;
    public static function refreshIncrement(){
        $last_data = Buku::orderBy('created_at', 'desc')->first();
        $last_count = $last_data ? (int)substr($last_data->IDBuku, 9) : 0;
        self::$increment_id = $last_count;
    }
    public static function generateBookID(){
        if(self::$increment_id == -1){
            self::refreshIncrement();
        }
        $last_count = self::$increment_id;
        $last_count += 1;
        $new_id = "B".date("dmY")."000";
        $counterlen = strlen((string)$last_count);
        $new_id = substr_replace($new_id, (string)$last_count, $counterlen * -1);
        self::$increment_id += 1;
        return $new_id;
    }
}