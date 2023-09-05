<?php

namespace App\Http\Controllers;

use App\Models\menuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    // Get menuModel Functions
    // public function get()
    // {
    //     $dt_menu=menuModel::get();
    //     return response()->json($dt_menu);
    // }
    public function get(Request $request){
        $get=menuModel::when($request->search, function ($query, $search) {
                return $query->where('jenis', 'like', "%{$search}%")
                ->orWhere('harga', 'like', "%{$search}%");
            })
            ->get();
        return response()->json($get);
    }

    // Post menuModel Functions
    public function createmenu(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'nama_menu'=>'required',
            'jenis'=>'required',
            'deskripsi'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'harga'=>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        // $image = $req->file('image');
        // $image->storeAs('public/images', $image->hashName());
        $image_path = $req->file('image')->store('images', 'public');

        $save = menuModel::create([
            'nama_menu'    =>$req->get('nama_menu'),
            'jenis'    =>$req->get('jenis'),
            'deskripsi'    =>$req->get('deskripsi'),
            'image'    =>$image_path,
            'harga'    =>$req->get('harga'),
        ]);
        if($save){
            return Response()->json(['status'=>true, 'message' =>'Sukses Menambah menu']);
        } else {
            return Response()->json(['status'=>false, 'message' =>'Gagal Menambah menu']);
        }

    }
    
    // Put menuModel Functions
    public function updatemenu(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'nama_menu'=>'required',
            'jenis'=>'required',
            'deskripsi'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'harga'=>'required',
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }

        $image_path = $req->file('image')->store('images', 'public');

        $ubah=menuModel::where('id',$id)->update([
            'nama_menu'    =>$req->get('nama_menu'),
            'jenis'    =>$req->get('jenis'),
            'deskripsi'    =>$req->get('deskripsi'),
            'image'    =>$image_path,
            'harga'    =>$req->get('harga'),
        ]);
        if($ubah){
            return Response()->json(['status'=>true, 'message' =>'Sukses Mengubah menu']);
        } else {
            return Response()->json(['status'=>false, 'message' =>'Gagal Mengubah menu']);
        }
    }

     // Delete Manu Functions
     public function destroymenu($id)
     {
         $hapus=menuModel::where('id',$id)->delete();
         if($hapus){
             return Response()->json(['status'=>true, 'message' =>'Sukses Hapus menu']);
         } else {
             return Response()->json(['status'=>false, 'message' =>'Gagal Hapus menu']);
         }
     }
}