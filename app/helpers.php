<?php
if (! function_exists('saveLog')) {

    function saveLog($data)
    {
       date_default_timezone_set('Asia/Baku');
       $log = new \App\Models\Log();
       $log->user_id = auth()->user()->id;
       $log->subj_id = !empty($data['subj_id'])? $data['subj_id']: null;
       $log->subj_table = !empty($data['subj_table'])? $data['subj_table']: null;
       $log->description = $data['description'];
       $log->ip_address = $_SERVER['REMOTE_ADDR'];
       $log->datetime = date('Y-m-d H:i:s');
       $log->save();

       return true;
    }
}
