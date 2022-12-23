<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Http\Resources\ApiResource;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class DosenController extends Controller
{
    public function index(){
        
        //get data from dosen
        // $data = Dosen::find(1111)->user;
        $data = Dosen::all();
        
        

        //return collection
        // return new ApiResource(true, 'List Data Dosen', $data);
        return new ApiResource(true, 'List Data Dosen', $data ,compact('data'));

    }
    //create
    public function store(Request $request)
    {
        //define validasi
        $validator = Validator::make($request->all(), [
            'nip'  => 'required',
            'nama'  => 'required',
            'email'  => 'required',
            'no_tlp'  => 'required',
            'foto'  => 'required|image|mimes:png,jpg|max:2048',
        ]);

        //check if validasi false
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        //upload images
        $image = $request->file('foto');
        $image->storeAs('public/dosen', $image->hashName());

        //create Post
        $dosen = Dosen::create([
            'nip'  =>$request->nip,
            'nama'  =>$request->nama,
            'email'  =>$request->email,
            'no_tlp'  =>$request->no_tlp,
            'foto'  =>$image->hashName(),

        ]);
        User::create([
            'user_dosen' =>$request->nip,
            'level' =>'2',
            'password' =>bcrypt($request->nip),
        ]);


        //return response
        return new ApiResource(true, 'Data Dosen berhasil Ditambahkan', $dosen);

    }
    //view by id
    public function show($id)
    {     
        $data = Dosen::find($id);
        return new ApiResource(true, 'Data Dosen Ditemukan', $data ,compact('data'));
    }
    //update
    public function update(Request $request, Dosen $dosen)
    {
        //define validation rules
        $validator = Validator::make($request->all(),[
            'nama'  => 'required',
            'email'  => 'required',
            'no_tlp'  => 'required',
            // 'foto'  => 'required',

        ]);
        //check if validation fails
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        //check if not empty
        if ($request->hasfile('foto')){
            //upload image
            $image = $request->file('foto');
            $image->storeAs('public/dosen', $image->hashName());
            //delete image
            Storage::delete('public/dosen/'.$dosen->foto);
            //update with new image
            $dosen->update([
                'nama'  => $request->nama,
                'email'  => $request->email,
                'no_tlp'  => $request->no_tlp,
                'foto'  => $image->hashName(),
       
            ]);
        } else {
            //update without image
            $dosen->update([
                'nama'  => $request->nama,
                'email'  => $request->email,
                'no_tlp'  => $request->no_tlp,
           
                
            ]);
        }
        //return response
        return new ApiResource(true, 'Data Dosen Berhasil Diubah', $dosen);

    }
    
    //Delete
    public function destroy(Dosen $dosen)
    {
        //delete image
        Storage::delete('public/dosen/'.$dosen->foto);
        //delete Dosen
        $dosen->delete();
        //return reponse
        return new ApiResource(true, 'Data Berhasil Dihapus', null);
    }
}
