<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public function index(){
        //get data from presensi
        // $presensis = presensi::latest()->paginate(5);
        $id = Presensi::select(
            'presensi.tanggal',
            'presensi.kehadiran',
            'presensi.sesi',
            'kelas.nama_kelas as nama_kelas',
            'dosen.nama as nama_dosen',
            'mahasiswa.nama as nama_mahasiswas',
            'matakuliah.nama_matkul as nama_matakuliah',
        )
        ->join('kelas', 'kelas.kd_kelas', '=', 'presensi.kd_kelas')
        ->join('mahasiswa', 'mahasiswa.nim', '=', 'presensi.nim')
        ->join('dosen', 'dosen.nip', '=', 'kelas.nip')
        ->join('matakuliah', 'matakuliah.kd_matkul', '=', 'kelas.kd_matkul')
        ->get()
        ->toArray();
        //return collection
        return new ApiResource(true, 'List Data presensi', $id);
        

    }
    //create
    public function store(Request $request)
    {
        //define validasi
        $validator = Validator::make($request->all(), [
            'tanggal'  => 'required',
            'kehadiran'  => 'required',
            'sesi'  => 'required',
            'kd_kelas'  => 'required',
            'nim'  => 'required',

        ]);

        //check if validasi false
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        //create Post
        $id = Presensi::create([
            'tanggal'  =>$request->tanggal,
            'kehadiran'  =>$request->kehadiran,
            'sesi'  =>$request->sesi,
            'kd_kelas'  =>$request->kd_kelas,
            'nim'  =>$request->nim,


        ]);

        //return response
        return new ApiResource(true, 'Data presensi berhasil Ditambahkan', $id);

    }
    //view by id
    public function show($id)
    {      
        $data = Presensi::select(
            'presensi.tanggal',
            'presensi.kehadiran',
            'presensi.sesi',
            'kelas.nama_kelas as nama_kelas',
            'dosen.nama as nama_dosen',
            'mahasiswa.nama as nama_mahasiswas',
            'matakuliah.nama_matkul as nama_matakuliah',
        )
        ->join('kelas', 'kelas.kd_kelas', '=', 'presensi.kd_kelas')
        ->join('mahasiswa', 'mahasiswa.nim', '=', 'presensi.nim')
        ->join('dosen', 'dosen.nip', '=', 'kelas.nip')
        ->join('matakuliah', 'matakuliah.kd_matkul', '=', 'kelas.kd_matkul')
        ->where('kd_presensi','=',$id)
        ->get()
        ->toArray();
        return new ApiResource(true, 'Data presensi Ditemukan', $data);
    }
    //update
    public function update(Request $request,$kd_presensi)
    {
        $model = presensi::find($kd_presensi);
        //define validation rules
        $validator = Validator::make($request->all(),[
            'tanggal'  => 'required',
            'kehadiran'  => 'required',
            'sesi'  => 'required',
            'kd_kelas'  => 'required',
            'nim'  => 'required',
        ]);
        //check if validation fails
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
            $model->update([
                'tanggal'  =>$request->tanggal,
                'kehadiran'  =>$request->kehadiran,
                'sesi'  =>$request->sesi,
                'kd_kelas'  =>$request->kd_kelas,
                'nim'  =>$request->nim,
            ]);
        
        //return response
        return new ApiResource(true, 'Data presensi Berhasil Diubah', $model);

    }
    
    //Delete
    public function destroy($id)
    {
        $data = presensi::find($id);
        //delete presensi
        $data->delete();
        //return reponse
        return new ApiResource(true, 'Data Berhasil Dihapus', null);
    }
    
}
