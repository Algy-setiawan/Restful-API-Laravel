<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Http\Resources\ApiResource;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;

class MataKuliahController extends Controller
{
    public function index(){
        //get data from matakuliah
        // $data = Matakuliah::all();
        // $matakuliah = Matakuliah::select()->get();
        $matakuliah = Matakuliah::with('dosen')->get();
        // $matakuliah = Matakuliah::select(
        //     'matakuliah.kd_matkul',
        //     'matakuliah.nama_matkul',
        //     'matakuliah.user_dosen',
        //     'dosen.nama as nama_dosen',
        // )
        // ->join('dosen', 'dosen.nip', '=', 'matakuliah.user_dosen')
        // ->get()
        // ->toArray();
        
        // $data = Matakuliah::find(5)->dosen;
        // $matakuliah = Matakuliah::whereBelongsTo($matakuliah)->get();
        //return collection
        return new ApiResource(true, 'List Data Matakuliah' ,compact('matakuliah'));
        // return new ApiResource(true, 'matakuliah',['matakuliah' => $matakuliah]);
    }
    //create
    public function store(Request $request)
    {
        //define validasi
        $validator = Validator::make($request->all(), [
            'nama_matkul'  => 'required',
            'user_dosen'  => 'required',

        ]);

        //check if validasi false
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        //create Post
        $matakuliah = Matakuliah::create([
            'nama_matkul'  =>$request->nama_matkul,
            'user_dosen'  =>$request->user_dosen,


        ]);

        //return response
        return new ApiResource(true, 'Data Matakuliah berhasil Ditambahkan', $matakuliah);

    }
    //view by id
    public function show($id)
    {
        
        // $data1 = Matakuliah::all('kd_matkul','nama_matkul');
        $data = Matakuliah::with('dosen')->find($id);
        // $posts = Matakuliah::where('user_dosen', $id->$id)->get();
        // $posts = Matakuliah::whereBelongsTo($id, 'user_dosen')->get();
        // return new ApiResource(true, 'Data Matakuliah Ditemukan', $data->dosen->nama ,compact('data'));
        return new ApiResource(true, 'Data Matakuliah Ditemukan' ,compact('data'));
    }
    //update

    // public function update(Request $request, Matakuliah $matakuliah)
    // {
    //     //define validation rules
    //     $validator = Validator::make($request->all(),[
    //         'nama_matkul'  => 'required'

    //     ]);
    //     //check if validation fails
    //     if ($validator->fails()){
    //         return response()->json($validator->errors(), 422);
    //     }
    //         $matakuliah->update([
    //             'nama_matkul'  => $request->nama_matkul
    //         ]);
        
    //     //return response
    //     return new ApiResource(true, 'Data Matakuliah Berhasil Diubah', $matakuliah);

    // }
    public function update(Request $request, Matakuliah $matakuliah)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nama_matkul' => 'required',
            'user_dosen' => 'required',

        ]);
   
        if($validator->fails()){
            return response()->json($validator->errors(), 422);      
        }
   
        $matakuliah->nama_matkul = $input['nama_matkul'];
        $matakuliah->user_dosen = $input['user_dosen'];
        $matakuliah->save();
        return new ApiResource(true, 'Data Matakuliah Berhasil Diubah', $matakuliah);
    }
    
    //Delete
    public function destroy(Matakuliah $matakuliah)
    {
        //delete Matakuliah
        $matakuliah->delete();
        //return reponse
        return new ApiResource(true, 'Data Berhasil Dihapus', null);
    }
}
