<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => ['required', 'unique:users'],
            'username' => ['required', 'unique:users'],
            'password' => 'required|min:6|confirmed',
        ]);

        // $store = User::create($request->all());
        $store = new User();
        $store->name = $request->name;
        $store->email = $request->email;
        $store->username = $request->username;
        $store->password = bcrypt($request->password);
        $store->save();


        if ($store) {
            return response()->json('OK', 200);
        } else {
            return response()->json('fail', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
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
        $validate = $request->validate([
            'name' => 'required',
            'email' => ['required'],
        ]);

        // $store = User::create($request->all()); (not secured)
        $store = User::find($id);
        $store->name = $request->name;
        $store->email = $request->email;
        $store->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::find($id)->delete();
        if ($delete) return response()->json('berhasil menghapus', 200);
    }
}
