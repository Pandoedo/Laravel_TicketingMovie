<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Movie $movies)
    {
          /**3# ini form search - Berikut kode search */
        $q   = $request->input('q');
        /** ini untuk menampilkan data dari tabel Users dan ketik kode ke view-list.blade*/
        $active = 'Movies';
        $movies   = $movies->when($q, function($query) use ($q) {
                    return $query->where('title', 'like', '%'.$q.'%');

        })
        
        ->paginate(10);
        $request    = $request->all(); /**4# ini form search - tambahkan kode ini */
        return view('dashboard/movie/list', [
                'movies'    =>$movies,
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
        //2# untuk ke menu form
        $active = 'Movies';
        return view('dashboard/movie/form',[
            'active'    =>$active,
            'button'   =>'Create',
            'url'      =>'dashboard.movies.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Movie $movie)
    {
        //1# Perintah create movie
        $validator      = VALIDATOR::make($request->all(), [
            'title'         => 'required|unique:App\Models\Movie,title',
            'description'   => 'required',
            'thumbnail'     => 'required|image'
        ]);
    
        if($validator->fails()){
            return redirect()
                    ->route('dashboard.movies.create')
                    ->withErrors($validator)
                    ->withInput();
        }else{
            //ini kode untuk input gambar / image
            $image      = $request->file('thumbnail');
            $filename   = time(). '.'. $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/movies', $image, $filename);

            $movie->title       = $request->input('title');
            $movie->description = $request->input('description');
            $movie->thumbnail   = $filename;
            $movie->save();

            return redirect()->route('dashboard.movies')
                            // ->with('message', 'Data berhasil ditambahkan');//#1 Alert Informasi
                            ->with('message', __('messages.store', ['title'=> $request->input('title')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
         //1# untuk ke menu form
         $active = 'Movies';
        //  $movie       = MOVIE::find($id);
         return view('dashboard/movie/form',[
             'active'   =>$active,
             'movie'    =>$movie,
             'button'   =>'Update',
             'url'      =>'dashboard.movies.update'
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validator      = VALIDATOR::make($request->all(),[
            'title'         => 'required|unique:App\Models\Movie,title,'.$movie->id,
            'description'   => 'required',
            'thumbnail'     => 'image'
        ]);
    
        if($validator->fails()){
            return redirect()
                    ->route('dashboard.movies.update', $movie->id)
                    ->withErrors($validator)
                    ->withInput();
        }else{
         //   ini kode untuk input gambar / image
            if($request->hasfile('thumbnail')){
                //koding diatas ini untuk validasi gambar atau tidak
                $image      = $request->file('thumbnail');
                $filename   = time(). '.'. $image->getClientOriginalExtension();
                Storage::disk('local')->putFileAs('public/movies', $image, $filename);
                $movie->thumbnail   = $filename;
            }
            $title  = $movie->title;

            $movie->title       = $request->input('title');
            $movie->description = $request->input('description');
            $movie->save();

            return redirect()->route('dashboard.movies')
            //->with('message', 'Data berhasil di update');//#3 Alert Informasi;
            ->with('message', __('messages.update', ['title'=> $title])); //Alert yang kedua
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $title  = $movie->title;
        $movie->delete();
        return redirect()->route('dashboard.movies')
        //->with('message', 'Data berhasil di delete');//#4 Alert Informasi;
        ->with('message', __('messages.delete', ['title'=> $title]));//Alert yang ke dua
    }
}
