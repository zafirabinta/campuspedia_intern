<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\InternData;
use Illuminate\Support\Facades\DB;
use Datatables;

class AjaxdataController extends Controller
{
    function index(){
        return view('intern_data.ajaxdata');

    }

    function getdata(){          
        $intern_datas = DB::table('intern_datas')
        ->select(DB::raw("
        jam_masuk, jam_pulang,
        (SELECT TIMEDIFF(jam_pulang, jam_masuk)) as jumlah_jam"),
        DB::raw("tanggal_kerja, (SELECT tanggal_kerja) as tanggal"),
        DB::raw("tugas, (SELECT tugas) as tugas"),
        DB::raw("kendala, (SELECT kendala) as kendala")); 
        return Datatables::of($intern_datas)->make(true);
    }

    function postdata(Request $request){
        $validation = Validator::make($request->all(), [
            'tanggal_kerja' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'tugas' => 'required',
            'kendala' => 'required'
        ]);

        $error_array = array();
        $success_output = '';
        if($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages;
            }
        }
        else{
            if($request->get('button_action') == "insert"){
                $intern_datas = new InternData([
                    'tanggal_kerja' => $request->get('tanggal_kerja'),
                    'jam_masuk' => $request->get('jam_masuk'),
                    'jam_pulang' => $request->get('jam_pulang'),
                    'tugas' => $request->get('tugas'),
                    'kendala' => $request->get('kendala')
                ]);
                $intern_datas->save();
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
            }
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output
        );
        echo json_encode($output);
    }
}
