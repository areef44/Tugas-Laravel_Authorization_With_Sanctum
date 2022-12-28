<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AuthorsController extends Controller
{
    public function index()
    {
        //show all author data data
        $author = Authors::query()->get();
        return response()->json([
            "status" => true,
            "message" => "",
            "data" => $author
        ]);
    }

    function show($id)
    {   //show all author data by id
        $author = Authors::query()
            ->where("id", $id)
            ->first();

        if ($author == null) { //kondisi ketika author tidak ada 
            return response()->json([
                "status" => false,
                "message" => "Author tidak ditemukan",
                "data" => null
            ]);
        }
        return response()->json([ //kondisi ketika author ada 
            "status" => true,
            "message" => "",
            "data" => $author

        ]);
    }

    function store(Request $request)
    {
        //get all author data 
        $payload = $request->all();

        //cek validasi data authors
        if (!isset($payload["name"])) { // cek kondisi ketika name kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada name",
                "data" => null
            ]);
        }

        if (!isset($payload["country"])) { // cek kondisi ketika country kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada country",
                "data" => null
            ]);
        }


        if (!isset($payload["birth_date"])) { // cek kondisi ketika birth_date kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada tanggal lahir",
                "data" => null
            ]);
        }

        if (!isset($payload["bio"])) { // cek kondisi ketika bio kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada bio",
                "data" => null
            ]);
        }

        if ($request->file("photo") != null) {
            //request file photo dari device
            $photo = $request->file("photo");

            //hash name foto 
            $filename = $photo->hashName();

            //move file to folder photo
            $photo->move("photo", $filename);

            //get url from file foto
            $payload['photo'] = $request->getSchemeAndHttpHost() . "/photo/" . $filename;
        } else {
            $payload['photo'] = "";
        }



        $author = Authors::create($payload);
        return response()->json([ //respon ketika data berhasil masuk
            "status" => true,
            "message" => "",
            "data" => $author
        ]);
    }

    function update(Request $request, $id)
    {
        //get all author data 
        $payload = $request->all();

        //cek validasi data authors
        if (!isset($payload["name"])) { // cek kondisi ketika name kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada name",
                "data" => null
            ]);
        }

        if (!isset($payload["country"])) { // cek kondisi ketika country kosong
            return response()->json([
                "status" => false,
                "message" => "country",
                "data" => null
            ]);
        }


        if (!isset($payload["birth_date"])) { // cek kondisi ketika birth_date kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada tanggal lahir",
                "data" => null
            ]);
        }

        if (!isset($payload["bio"])) { // cek kondisi ketika bio kosong
            return response()->json([
                "status" => false,
                "message" => "wajib ada bio",
                "data" => null
            ]);
        }

        if ($request->file("photo") != null) {
            //request file photo dari device
            $photo = $request->file("photo");

            //hash name foto 
            $filename = $photo->hashName();

            //move file to folder photo
            $photo->move("photo", $filename);

            //get url from file foto
            $payload['photo'] = $request->getSchemeAndHttpHost() . "/photo/" . $filename;
        }



        $author = Authors::find($id);
        $author->fill($payload);
        $author->save();
        return response()->json([ //respon ketika data berhasil masuk
            "status" => true,
            "message" => "",
            "data" => $author
        ]);
    }

    public function delete($id)
    {
        $author = Authors::query()
            ->where("id", $id)
            ->first();



        if ($author == null) {
            return response()->json([
                "status" => false,
                "message" => "author tidak ditemukan",
                "data" => null
            ]);
        }

        // dd($author->photo);

        $path = parse_url($author->photo);
        unlink(public_path() . $path['path']);
        $author->delete();

        return response()->json([
            "status" => true,
            "message" => "Author Berhasil Dihapus",
            "data" => $author
        ]);
    }
}
