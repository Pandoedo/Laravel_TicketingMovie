<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;//1# ini langkah membuat validasi

class UserController extends Controller
{

    // 1# ini untuk pembuatan middleware / auth

    // public function __construct(){
    //     $this->middleware('auth');
    // 2# Namun dihapus kembali dan dibuat didalam route group untuk efisien}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**2# ini form search - Tambahkan request */
    public function index(Request $request, User $users)
    {
          /**3# ini form search - Berikut kode search */
        $q   = $request->input('q');
        /** ini untuk menampilkan data dari tabel Users dan ketik kode ke view-list.blade*/
        $active = 'Users';
        $users   = $users->when($q, function($query) use ($q) {
                    return $query->where('name', 'like', '%'.$q.'%')
                                    ->orWhere('email', 'like', '%'.$q.'%');
        })
        
        ->paginate(10);
        $request    = $request->all(); /**4# ini form search - tambahkan kode ini */
        return view('dashboard/user/list', [
                'users'     =>$users,
                'request'   =>$request,
                'active'    =>$active
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /**ini untuk edit user*/
        $user       = USER::find($id);
        $active     = 'Users';
        return view ('dashboard/user/form', ['user' =>$user, 'active' => $active ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**ini untuk update user*/
        $user       = USER::find($id);

        //2# ini langkah membuat validasi
        $validator = VALIDATOR::make($request->all(),
        [
        'name'  => 'required',
        'email' => 'required|unique:App\Models\User,email,'.$id
        ]);
        //3# ini langkah membuat validasi lanjut ke view -> form.blade
        if($validator->fails()){
            return redirect('dashboard/users/'.$id)
                    ->withErrors($validator)
                    ->withInput();
        }else{

            $user->name = $request->input('name');
            $user->email= $request->input('email');
            $user->save();
    
            return redirect('dashboard/users')
            ->with('message', 'Data berhasil di update');;

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**ini untuk menghapus*/
        $user       = USER::find($id);
        $user->delete();

        return redirect('dashboard/users')
        ->with('message', 'Data berhasil di delete');;
    }
}
