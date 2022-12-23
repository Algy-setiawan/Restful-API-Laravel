<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class MahasiswaController extends Controller
{
    public function index(){
        //get data from mahasiswa
        $data = Mahasiswa::all();

        //return collection
        return new ApiResource(false, 'List Data Mahasiswa', $data);

    }
    //create
    public function store(Request $request)
    {
        //define validasi
        $validator = Validator::make($request->all(), [
            'nim'  => 'required',
            'nama'  => 'required',
            'email'  => 'required',
            'no_tlp'  => 'required',
            'jurusan'  => 'required',  
            'jk'  => 'required',  
            'foto'  => 'required|image|mimes:png,jpg|max:2048',
        ]);

        //check if validasi false
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        //upload images
        $image = $request->file('foto');
        $image->storeAs('public/mahasiswa', $image->hashName());

        //create Post
        $mahasiswa = Mahasiswa::create([
            'nim'  =>$request->nim,
            'nama'  =>$request->nama,
            'email'  =>$request->email,
            'no_tlp'  =>$request->no_tlp,
            'jurusan'  =>$request->jurusan,
            'jk'  =>$request->jk,
            'foto'  =>$image->hashName(),

        ]);
        User::create([
            'user_mahasiswa' =>$request->nim,
            'level' =>'3',
            'password' =>bcrypt($request->nim),
        ]);

        //return response
        return new ApiResource(true, 'Data Mahasiswa berhasil Ditambahkan', $mahasiswa);

    }
    //view by id
    public function show($id)
    {
        $data = Mahasiswa::find($id);
        return new ApiResource(true, 'Data Mahasiswa Ditemukan', $data);
    }
    //update
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        //define validation rules
        $validator = Validator::make($request->all(),[
            'nama'  => 'required',
            'email'  => 'required',
            'no_tlp'  => 'required',
            'jurusan'  => 'required',
            'jk'  => 'required',
        
          
        ]);
        //check if validation fails
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        //check if not empty
        if ($request->hasfile('foto')){
            //upload image
            $image = $request->file('foto');
            $image->storeAs('public/mahasiswa', $image->hashName());
            //delete image
            Storage::delete('public/mahasiswa/'.$mahasiswa->foto);
            //update with new image
            $mahasiswa->update([
                'nama'  => $request->nama,
                'email'  => $request->email,
                'no_tlp'  => $request->no_tlp,
                'jurusan'  => $request->jurusan,
                'jk'  => $request->jk,
                'foto'  => $image->hashName(),
            ]);
        } else {
            //update without image
            $mahasiswa->update([
                'nama'  => $request->nama,
                'email'  => $request->email,
                'no_tlp'  => $request->no_tlp,
                'jurusan'  => $request->jurusan,
                'jk'  => $request->jk,
              
            ]);
        }
        //return response
        return new ApiResource(true, 'Data Mahasiswa Berhasil Diubah', $mahasiswa);

    }
    
    //Delete
    public function destroy(Mahasiswa $mahasiswa)
    {
        //delete image
        Storage::delete('public/Mahasiswa/'.$mahasiswa->foto);
        //delete Mahasiswa
        $mahasiswa->delete();
        //return reponse
        return new ApiResource(true, 'Data Berhasil Dihapus', null);
    }
}
