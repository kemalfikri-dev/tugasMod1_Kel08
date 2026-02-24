<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // public function show all values from a table
    public function index()
    {
        $datas = DB::select('select * from admin where deleted_at is null'); 
        return view('admin.index')->with('datas', $datas);
    }

    public function create()
    {
        return view('admin.add');
    }

    public function store(Request $request)
    {
        $request->validate(['id_admin' => 'required', 'nama' => 'required', 'alamat' => 'required', 'username' => 'required', 'password' => 'required',]);
        DB::insert(
            'INSERT INTO admin(id_admin,nama, alamat, username, password) VALUES (:id_admin, :nama, :alamat, :username, :password)',
            [
                'id_admin' => $request->id_admin,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil disimpan');
    }

    // public function edit a row from a table 
    public function edit($id)
    {
        $data = DB::table('admin')->where('id_admin', $id)->first();
        return view('admin.edit')->with('data', $data);
    }
    // public function to update the table value 
    public function update($id, Request $request)
    {
        $request->validate([
            'id_admin' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        DB::update(
            'UPDATE admin SET id_admin = :id_admin, nama =
    :nama, alamat = :alamat, username = :username, password =
    :password WHERE id_admin = :id',
            [
                'id' => $id,
                'id_admin' => $request->id_admin,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
            ]
        );
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diubah');
    }
    
    public function delete($id)
    {
        DB::update('UPDATE admin SET deleted_at = NOW() WHERE id_admin = :id', ['id' => $id]);
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus');
    }

    public function trash()
    {
        $datas = DB::select('select * from admin where deleted_at is not null'); 
        return view('admin.trash')->with('datas', $datas); 
    }

    public function undo($id) {
        DB::update('UPDATE admin SET deleted_at = NULL WHERE id_admin = :id', ['id' => $id]);
        return redirect()->route('admin.trash')->with('success', 'Data Admin berhasil diundo');
    }

    public function undoAll()
    {
    DB::update('UPDATE admin SET deleted_at = NULL WHERE deleted_at IS NOT NULL');
    return redirect()->route('admin.trash')->with('success', 'Data Admin berhasil diundo semua');
    }

    public function deletePermanent($id)
    {
        DB::delete('DELETE FROM admin WHERE id_admin = :id_admin', ['id_admin' => $id]);
        return redirect()->route('admin.trash')->with('success', 'Data Admin berhasil dihapus');
    }

}