<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\Models\Books;
use App\Models\Categories;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::query()->get();

        $collection = $books->map(function ($book) {
            $book['categories'] = Categories::query()->where('id', $book->id_categories)->first();
            $book['authors'] = Authors::query()->where('id', $book->id_authors)->first();
            return $book;
        })->reject(function ($book) {
            return empty($book);
        });

        //get all book data
        // $books = Books::select('*')
        //     ->join("categories", "categories.id", "=", "books.id_categories")
        //     ->join("authors", "authors.id", "=", "books.id_authors")
        //     ->get();
        return response()->json([
            "status" => true,
            "message" => "",
            "data" => $collection
        ]);
    }

    function show($id)
    {
        //show book data by id
        $book['book'] = $books = Books::query()
            ->where("id", $id)
            ->first();

        //show all object category in book data 
        $book['book']['categories'] = $category = Categories::query()
            ->where("id", $books->id_categories)->get();

        //show all object authors in book data 
        $book['book']['authors'] = $author = Authors::query()
            ->where("id", $books->id_authors)->get();

        //cek data semua buku     
        if ($books == null) { //jika null
            return response()->json([
                "status" => false,
                "message" => "Buku tidak ditemukan",
                "data" => null
            ]);
        }
        return response()->json([ //jika tersedia
            "status" => true,
            "message" => "",
            "data" => $books

        ]);
    }

    function store(Request $request)
    {
        //cek validasi data buku
        $payload = $request->all();
        if (!isset($payload["title"])) { // kondisi jika title tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada title",
                "data" => null
            ]);
        }

        if (!isset($payload["id_authors"])) { // kondisi jika id_authors tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada harga Author",
                "data" => null
            ]);
        }


        if (!isset($payload["id_categories"])) { // kondisi jika id_category tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada Categories",
                "data" => null
            ]);
        }

        if (!isset($payload["publisher"])) { // kondisi jika publisher tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada penerbit",
                "data" => null
            ]);
        }

        if (!isset($payload["released_date"])) { // kondisi jika released_date tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada tahun terbit",
                "data" => null
            ]);
        }

        if (!isset($payload["print_date"])) { // kondisi jika print_date tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada tahun cetak",
                "data" => null
            ]);
        }

        if (!isset($payload["pages_number"])) { // kondisi jika pages_number tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada jumlah halaman",
                "data" => null
            ]);
        }


        if (!isset($payload["rating"])) { // kondisi jika rating tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada rating",
                "data" => null
            ]);
        }

        if (!isset($payload["sinopsis"])) { // kondisi jika sinopsis tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada sinopsis",
                "data" => null
            ]);
        }

        if ($request->file("picture") != null) {
            //request file photo dari device
            $thumbnail = $request->file("picture");

            //hash name foto 
            $filename = $thumbnail->hashName();

            //move file to folder photo
            $thumbnail->move(
                "picture",
                $filename
            );

            //get url from file foto
            $payload['picture'] = $request->getSchemeAndHttpHost() . "/picture/" . $filename;
        } else {
            $payload['picture'] = "";
        }

        //query save all data to database
        $books = Books::query()->create($payload);
        return response()->json([ //respon when success
            "status" => true,
            "message" => "",
            "data" => $books
        ]);
    }

    function update(Request $request, $id)
    {
        //cek validasi data buku
        $payload = $request->all();
        if (!isset($payload["title"])) { // kondisi jika title tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada title",
                "data" => null
            ]);
        }

        if (!isset($payload["id_authors"])) { // kondisi jika id_authors tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada harga Author",
                "data" => null
            ]);
        }


        if (!isset($payload["id_categories"])) { // kondisi jika id_category tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada Categories",
                "data" => null
            ]);
        }

        if (!isset($payload["publisher"])) { // kondisi jika publisher tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada penerbit",
                "data" => null
            ]);
        }

        if (!isset($payload["released_date"])) { // kondisi jika released_date tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada tahun terbit",
                "data" => null
            ]);
        }

        if (!isset($payload["print_date"])) { // kondisi jika print_date tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada tahun cetak",
                "data" => null
            ]);
        }

        if (!isset($payload["pages_number"])) { // kondisi jika pages_number tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada jumlah halaman",
                "data" => null
            ]);
        }


        if (!isset($payload["rating"])) { // kondisi jika rating tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada rating",
                "data" => null
            ]);
        }

        if (!isset($payload["sinopsis"])) { // kondisi jika sinopsis tidak diinput
            return response()->json([
                "status" => false,
                "message" => "wajib ada sinopsis",
                "data" => null
            ]);
        }


        if (
            $request->file("picture") != null
        ) {
            //request file photo dari device
            $thumbnail = $request->file("picture");

            //hash name foto 
            $filename = $thumbnail->hashName();

            //move file to folder photo
            $thumbnail->move("picture", $filename);

            //get url from file foto
            $payload['picture'] = $request->getSchemeAndHttpHost() . "/picture/" . $filename;
        }

        $books = Books::find($id);
        $books->fill($payload);
        $books->save();
        return response()->json([ //respon ketika data berhasil diinput
            "status" => true,
            "message" => "",
            "data" => $books
        ]);
    }

    function destroy($id)
    {

        $books = Books::query()
            ->where("id", $id)
            ->first();

        if ($books == null) {
            return response()->json([
                "status" => false,
                "message" => "Buku tidak ditemukan",
                "data" => null
            ]);
        }

        // dd($author->photo);

        $path = parse_url($books->picture);
        unlink(public_path() . $path['path']);
        $books->delete();

        return response()->json([
            "status" => true,
            "message" => "Buku Berhasil Dihapus",
            "data" => $books
        ]);
    }
}
