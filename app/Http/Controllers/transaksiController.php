<?php

namespace App\Http\Controllers;

use App\Models\transaksiModel;
use App\Models\detailtransaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class transaksiController extends Controller
{
    //Transaksi
    public function gettransaksi(Request $request){
        $get=transaksiModel::when($request->search, function ($query, $search){
            return $query->where('status', 'like', "%{$search}%")
            ->orWhere('tgl_transaksi', 'like', "%{search}%");
        })
        ->get();
        return response()->json($get);
    }
    public function createtransaksi(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'tgl_transaksi'=>'required',
            'id_user'=>'required',
            'id_meja'=>'required',
            'nama_pelanggan'=>'required',
            'status'=>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $save = transaksiModel::create([
            'tgl_transaksi'    =>$req->get('tgl_transaksi'),
            'id_user'    =>$req->get('id_user'),
            'id_meja'    =>$req->get('id_meja'),
            'nama_pelanggan'    =>$req->get('nama_pelanggan'),
            'status'    =>$req->get('status'),

        ]);
        if($save){
            return Response()->json(['status'=>true, 'message' =>'Sukses Menambah Transaksi']);
        } else {
            return Response()->json(['status'=>false, 'message' =>'Gagal Menambah Transaksi']);
        }
    }
    public function updatetransaksi(Request $req, $id)
        {
            $validator = Validator::make($req->all(),[
                'tgl_transaksi'=>'required',
                'id_user'=>'required',
                'id_meja'=>'required',
                'nama_pelanggan'=>'required',
                'status'=>'required',
            ]);
            if($validator->fails()){
                return Response()->json($validator->errors()->toJson());
            }
            $ubah=transaksiModel::where('id',$id)->update([
                'tgl_transaksi'    =>$req->get('tgl_transaksi'),
                'id_user'    =>$req->get('id_user'),
                'id_meja'    =>$req->get('id_meja'),
                'nama_pelanggan'    =>$req->get('nama_pelanggan'),
                'status'    =>$req->get('status'),
            ]);
            if($ubah){
                return Response()->json(['status'=>true, 'message' =>'Sukses Mengubah Transaksi']);
            } else {
                return Response()->json(['status'=>false, 'message' =>'Gagal Mengubah Transaksi']);
            }
        }
        public function getdtltransaksi($id)
        {
            $dt=transaksiModel::where('id',$id)->first();
            return Response()->json($dt);
        }
        public function destroytransaksi($id)
        {
            $hapus=transaksiModel::where('id',$id)->delete();
            if($hapus){
                return Response()->json(['status'=>true, 'message' =>'Sukses Hapus Transaksi']);
            } else {
                return Response()->json(['status'=>false, 'message' =>'Gagal Hapus Transaksi']);
            }
        }


        //Detail
                public function getdetail()
            {
                $dt_menu=detailtransaksiModel::get();
                return response()->json($dt_menu);
            }
            public function createdetail(Request $req)
            {
                $validator = Validator::make($req->all(),[
                    'id_transaksi'=>'required',
                    'id_menu'=>'required',
                    'qty'=>'required',
                    'harga'=>'required',
        
                ]);
                if($validator->fails()){
                    return Response()->json($validator->errors()->toJson());
                }
                $save = detailtransaksiModel::create([
                    'id_transaksi'    =>$req->get('id_transaksi'),
                    'id_menu'    =>$req->get('id_menu'),
                    'qty'    =>$req->get('qty'),
                    'harga'    =>$req->get('harga'),
        
                ]);
                if($save){
                    return Response()->json(['status'=>true, 'message' =>'Sukses Menambah Detail']);
                } else {
                    return Response()->json(['status'=>false, 'message' =>'Gagal Menambah Detail']);
                }
            }
            public function updatedetail(Request $req, $id_transaksi)
                {
                    $validator = Validator::make($req->all(),[
                        'id_transaksi'=>'required',
                        'id_menu'=>'required',
                        'qty'=>'required',
                        'harga'=>'required',
                    ]);
                    if($validator->fails()){
                        return Response()->json($validator->errors()->toJson());
                    }
                    $ubah=detailtransaksiModel::where('id_transaksi',$id_transaksi)->update([
                        'id_transaksi'    =>$req->get('id_transaksi'),
                        'id_menu'    =>$req->get('id_menu'),
                        'qty'    =>$req->get('qty'),
                        'harga'    =>$req->get('harga'),
                    ]);
                    if($ubah){
                        return Response()->json(['status'=>true, 'message' =>'Sukses Mengubah Detail']);
                    } else {
                        return Response()->json(['status'=>false, 'message' =>'Gagal Mengubah Detail']);
                    }
                }
                public function getdetailtransaksi($id_transaksi)
                {
                    $dt=detailtransaksiModel::where('id',$id_transaksi)->first();
                    return Response()->json($dt);
                }
                public function destroydetail($id_transaksi)
                {
                    $hapus=detailtransaksiModel::where('id',$id_transaksi)->delete();
                    if($hapus){
                        return Response()->json(['status'=>true, 'message' =>'Sukses Hapus Detail']);
                    } else {
                        return Response()->json(['status'=>false, 'message' =>'Gagal Hapus Detail']);
                    }
                }
        }

