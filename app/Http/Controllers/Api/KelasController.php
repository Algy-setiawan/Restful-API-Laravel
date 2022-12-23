<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index(){
        //get data from Kelas
        // $kelass = kelas::latest()->paginate(5);
        //query join
        $id = Kelas::select(
            'kelas.kd_kelas',
            'kelas.nama_kelas',
            'dosen.nama as nama_dosen',
            'mahasiswa.nama as nama_mahasiswa',
            'matakuliah.nama_matkul as nama_matakuliah'
        )
        ->join('dosen', 'dosen.nip', '=', 'kelas.nip')
        ->join('mahasiswa', 'mahasiswa.nim', '=', 'kelas.nim')
        ->join('matakuliah', 'matakuliah.kd_matkul', '=', 'kelas.kd_matkul')
        ->get()
        ->toArray();
        //return collection
        return new ApiResource(true, 'List Data Kelas', $id);
        

    }
    //create
    public function store(Request $request)
    {
        //define validasi
        $validator = Validator::make($request->all(), [
            'nama_kelas'  => 'required',
            'nip'  => 'required',
            'nim'  => 'required',
            'kd_matkul'  => 'required',

        ]);

        //check if validasi false
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        //create Post
        $kelas = Kelas::create([
            'nama_kelas'  =>$request->nama_kelas,
            'nip'  =>$request->nip,
            'nim'  =>$request->nim,
            'kd_matkul'  =>$request->kd_matkul,


        ]);

        //return response
        return new ApiResource(true, 'Data Kelas berhasil Ditambahkan', $kelas);

    }
    //view by id
    public function show($id)
    {
        $data = Kelas::select(
            'kelas.nama_kelas',
            'dosen.nama as nama_dosen',
            'mahasiswa.nama as nama_mahasiswa',
            'matakuliah.nama_matkul as nama_matakuliah'
        )
        ->join('dosen', 'dosen.nip', '=', 'kelas.nip')
        ->join('mahasiswa', 'mahasiswa.nim', '=', 'kelas.nim')
        ->join('matakuliah', 'matakuliah.kd_matkul', '=', 'kelas.kd_matkul')
        ->where('kd_kelas','=',$id)
        ->get()
        ->toArray();      
        // $data = Kelas::find('1');
        // echo($id);
        return new ApiResource(true, 'Data Kelas Ditemukan', $data);
    }
    //update
    public function update(Request $request,$kd_kelas)
    {
        $id = Kelas::find($kd_kelas);
        //define validation rules
        $validator = Validator::make($request->all(),[
            'nama_kelas'  => 'required',
            'nip'  => 'required',
            'nim'  => 'required',
            'kd_matkul'  => 'required',

        ]);
        //check if validation fails
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
            $id->update([
                'nama_kelas'  => $request->nama_kelas,
                'nip'  => $request->nip,
                'nim'  => $request->nim,
                'kd_matkul'  => $request->kd_matkul,
            ]);
        
        //return response
        return new ApiResource(true, 'Data Kelas Berhasil Diubah', $id);

    }
    
    //Delete
    public function destroy($id)
    {
        $data = Kelas::find($id);
        //delete Kelas
        $data->delete();
        //return reponse
        return new ApiResource(true, 'Data Berhasil Dihapus', null);
    }
}
