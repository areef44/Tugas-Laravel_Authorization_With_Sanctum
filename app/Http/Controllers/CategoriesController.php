<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        //get all data from categories table
        $category = Categories::query()->get();
        return response()->json([ // respon when data ditemukan
            "status" => true,
            "message" => "",
            "data" => $category
        ]);
    }

    function show($id)
    {
        //show category by id
        $category = Categories::query()
            ->where("id", $id)
            ->first();

        // dd($category);
        if ($category == null) { //kondisi ketika data category tidak ditemukan
            return response()->json([
                "status" => false,
                "message" => "kategori tidak ditemukan",
                "data" => null
            ]);
        }
        return response()->json([ //kondisi ketika data category tersedia
            "status" => true,
            "message" => "",
            "data" => $category
        ]);
    }

    function store(Request $request)
    {
        //cek validasi data category
        $payload = $request->all();
        if (!isset($payload["category"])) { //kondisi ketika name null
            return response()->json([
                "status" => false,
                "message" => "wajib ada name",
                "data" => null
            ]);
        }

        if (!isset($payload["description"])) { //kondisi ketika description null
            return response()->json([
                "status" => false,
                "message" => "description",
                "data" => null
            ]);
        }


        if ($request->file("thumbnail") != null) {
            //request file photo dari device
            $thumbnail = $request->file("thumbnail");

            //hash name foto 
            $filename = $thumbnail->hashName();

            //move file to folder photo
            $thumbnail->move("thumbnail", $filename);

            //get url from file foto
            $payload['thumbnail'] = $request->getSchemeAndHttpHost() . "/thumbnail/" . $filename;
        } else {
            $payload['thumbnail'] = "";
        }

        $category = Categories::create($payload);
        return response()->json([ //respon ketika data berhasil diinput
            "status" => true,
            "message" => "",
            "data" => $category
        ]);
    }

    function update(Request $request, $id)
    {
        //cek validasi data category
        $payload = $request->all();
        if (!isset($payload["category"])) { //kondisi ketika name null
            return response()->json([
                "status" => false,
                "message" => "wajib ada category",
                "data" => null
            ]);
        }

        if (!isset($payload["description"])) { //kondisi ketika description null
            return response()->json([
                "status" => false,
                "message" => "description",
                "data" => null
            ]);
        }


        if ($request->file("thumbnail") != null) {
            //request file photo dari device
            $thumbnail = $request->file("thumbnail");

            //hash name foto 
            $filename = $thumbnail->hashName();

            //move file to folder photo
            $thumbnail->move("thumbnail", $filename);

            //get url from file foto
            $payload['thumbnail'] = $request->getSchemeAndHttpHost() . "/thumbnail/" . $filename;
        }

        $category = Categories::find($id);
        $category->fill($payload);
        $category->save();
        return response()->json([ //respon ketika data berhasil diinput
            "status" => true,
            "message" => "",
            "data" => $category
        ]);
    }

    function destroy($id)
    {

        $categories = Categories::query()
            ->where("id", $id)
            ->first();

        if ($categories == null) {
            return response()->json([
                "status" => false,
                "message" => "Kategori tidak ditemukan",
                "data" => null
            ]);
        }

        // dd($author->photo);

        $path = parse_url($categories->thumbnail);
        unlink(public_path() . $path['path']);
        $categories->delete();

        return response()->json([
            "status" => true,
            "message" => "Kategori Berhasil Dihapus",
            "data" => $categories
        ]);
    }
}
