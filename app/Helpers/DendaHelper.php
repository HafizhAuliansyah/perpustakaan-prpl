<?php
namespace App\Helpers;
 
use Illuminate\Support\Facades\DB;
use App\Models\Denda;
 
class DendaHelper {
    static $increment_id = -1;
    public static function refreshIncrement(){
        $last_data = DB::table('denda')
            ->select(
                'IDDenda',
                DB::raw('substring("IDDenda", 10, 5) as number_id')
            )
            ->orderByDesc('number_id')
            ->first();
            $last_count = $last_data ? (int)substr($last_data->IDDenda, 9) : 0;
        self::$increment_id = $last_count;
    }
    public static function generateDendaID(){
        if(self::$increment_id == -1){
            self::refreshIncrement();
        }
        $last_count = self::$increment_id;
        $last_count += 1;
        $new_id = "D".date("dmY")."00000";
        $counterlen = strlen((string)$last_count);
        $new_id = substr_replace($new_id, (string)$last_count, $counterlen * -1);
        self::$increment_id += 1;
        return $new_id;
    }
}