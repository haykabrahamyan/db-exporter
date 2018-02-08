<?php

namespace Haykabrahamyan\DbExporter;

use App\Http\Controllers\Controller;

class DbExporterController extends Controller
{
    public static function doExport(){
        $return_var = NULL;
        $output = NULL;
        $command = env('DbExporter_MYSQLDUMP') . " -u ".env('DB_USERNAME')." -h ".env('DB_HOST')." -p'".env('DB_PASSWORD')."' ".env('DB_DATABASE')." > ".env('DbExporter_PATH').env('DB_DATABASE').".sql";
        exec($command, $output, $return_var);
        if (!$return_var){
            self::uploadDrive();
        }
     }

    public static function uploadDrive(){
        $a  = file_get_contents(env('DbExporter_PATH').env('DB_DATABASE').".sql");
        \Storage::disk('google')->put(env('DB_DATABASE').".sql", $a);
    }
}
