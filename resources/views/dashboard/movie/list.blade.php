{{-- ini form untuk memanggil data dari database --}}
@extends('layouts.dashboard')
{{--1# untuk menambah form create--}}
    @section('content')
    <div class="mb-2">
      <a href="{{ route('dashboard.movies.create') }}" class="btn btn-primary btn-sm">+ Movie</a>
    </div>


    @if(session()->has('message')){{--#2 Alert Informasi--}}
    <div class="alert alert-success" role="alert">
        <strong>{{ session()->get('message') }}</strong>
          <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
          </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3>Movies</h3>
                </div>



{{-- 1# ini form search --}}               
            <div class="col-4">
              <form method="get" action="{{ route('dashboard.movies') }}">
                  <div class="input-group">
                  <input class="text" class="form-control form-control-sm" name="q" value="{{ $request['q'] ?? '' }}">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-secondary btn-sm">Search</button>
                    </div>
                  </div>
                </form>
              </div>
          </div>

   
        </div>
        <div class="card-body">
          @if($movies->total()) {{-- 1# ini untuk melakukan perintah belum ada data movie--}}
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Title</th>

                  </tr>
                </thead>
                @foreach ($movies AS $movie)
                <tbody>
                  <tr>
                    {{-- ini pengulangan nomor urut --}}
                    <th scope="row">{{ ($movies->currentPage()-1) * $movies->perPage() + $loop->iteration}}</th>

                    <td class="col-thumbnail">
                      <img src="{{ asset('storage/movies/'.$movie->thumbnail)}}" class="img-fluid">
                    </td>

                    <td><h4><strong>{{ $movie->title }}</strong></h4></td>

                    <td>

                    <a href="{{ route('dashboard.movies.edit', $movie->id) }}" class="btn btn-success btn-sm" title='Edit'><i class="fas fa-pen"></i></a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              {{--5# ini form search - tambahkan kode ini --}}
              {{ $movies->appends($request)->links() }}

              @else {{-- 2# ini untuk melakukan perintah belum ada data movie--}}
              <h4 class="text-center p-3">Belum ada data Movie</h4>{{-- 3# ini untuk melakukan perintah belum ada data movie--}}
              @endif
        </div>
      </div>
    

        
    @endsection