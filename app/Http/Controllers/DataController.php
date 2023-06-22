<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Origin;
use Illuminate\Http\Request;

class DataController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $db_backendpillar = Destination::where('destination', 'LIKE', '%' . $request->search . '%')
            ->orderBy('destination', 'asc')
                ->get();
        } else {
            $db_backendpillar = Destination::with('origin')
            ->orderBy('origin_id', 'asc')
                ->get();
        }

        return view('insert', ['db_backendpillar' => $db_backendpillar]);
    }

    public function insertdata(Request $request)
    {
        $this->validate($request, [
            'origin' => 'required',
            'destination' => 'required',
            'kendaraan' => 'required',
            'ongkir' => 'required',
        ]);
        if ($request->isMethod('post')) {

            $destination = new Destination();
            $destination->origin_id = $request->origin;
            $destination->destination = $request->destination;
            $destination->kendaraan = $request->kendaraan;
            $destination->ongkir = $request->ongkir;
            $destination->save();

            return redirect()->route('insert')->with('success', 'Data Berhasil Di Tambahkan');
        }
    }

    public function data(Request $request)
    {
        if ($request->has('search')) {
            $db_backendpillar = Destination::where('destination', 'LIKE', '%' . $request->search . '%')
            ->orderBy('destination', 'asc')
                ->get();
        } else {
            $db_backendpillar = Destination::with('origin')
            ->orderBy('origin_id', 'asc')
                ->get();
        }

        return view('insert', ['db_backendpillar' => $db_backendpillar]);
    }

    public function editData($id)
    {
        $destination = Destination::find($id);
        $origins = Origin::all();

        return view('editdata', compact('destination', 'origins'));
    }

    public function updateData(Request $request, $id)
    {
        $this->validate($request, [
            'origin' => 'required',
            'destination' => 'required',
            'kendaraan' => 'required',
            'ongkir' => 'required',
        ]);
        if ($request->isMethod('post')) {

            $destination = Destination::find($id);
            $destination->origin_id = $request->origin;
            $destination->destination = $request->destination;
            $destination->kendaraan = $request->kendaraan;
            $destination->ongkir = $request->ongkir;
            $destination->save();

            return redirect()->route('insert')->with('success', 'Data Berhasil Diubah');
        }
    }

    public function insert(Request $request)
    {
        if ($request->has('search')) {
            $db_backendpillar = Destination::where('destination', 'LIKE', '%' . $request->search . '%')
                ->orderBy('destination', 'asc')
                ->get();
        } else {
            $db_backendpillar = Destination::with('origin')
                ->orderBy('origin_id', 'asc')
                ->get();
        }

        return view('insert', ['db_backendpillar' => $db_backendpillar]);
    }

    public function delete($id)
    {
        $destination = Destination::find($id);
        if ($destination) {
            $destination->forceDelete();
            return redirect()->route('insert')->with('success', 'Data berhasil dihapus secara permanen.');
        } else {
            return redirect()->route('insert')->with('error', 'Data tidak ditemukan.');
        }
    }
}
