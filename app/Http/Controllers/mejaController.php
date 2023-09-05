<?php

namespace App\Http\Controllers;

use App\Models\mejaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class mejaController extends Controller
{
    public function getmeja()
    {
        $dt_meja=mejaModel::get();
        return response()->json($dt_meja);
    }
    public function createmeja(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'nomor_meja'=>'required',

        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $save = mejaModel::create([
            'nomor_meja'    =>$req->get('nomor_meja'),

        ]);
        if($save){
            return Response()->json(['status'=>true, 'message' =>'Sukses Menambah Meja']);
        } else {
            return Response()->json(['status'=>false, 'message' =>'Gagal Menambah Meja']);
        }
    }
    public function updatemeja(Request $req, $id)
        {
            $validator = Validator::make($req->all(),[
                'nomor_meja'=>'required',
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors()->toJson());
            }
            $ubah=mejaModel::where('id',$id)->update([
                'nomor_meja'    =>$req->get('nomor_meja'),
            ]);
            if($ubah){
                return Response()->json(['status'=>true, 'message' =>'Sukses Mengubah Meja']);
            } else {
                return Response()->json(['status'=>false, 'message' =>'Gagal Mengubah Meja']);
            }
        }
        public function getdetailmeja($id)
        {
            $dt=mejaModel::where('id',$id)->first();
            return Response()->json($dt);
        }
        public function destroymeja($id)
        {
            $hapus=mejaModel::where('id',$id)->delete();
            if($hapus){
                return Response()->json(['status'=>true, 'message' =>'Sukses Hapus Meja']);
            } else {
                return Response()->json(['status'=>false, 'message' =>'Gagal Hapus Meja']);
            }
        }
}
