{{-- ini form untuk memanggil data dari database --}}
@extends('layouts.dashboard')

    @section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 align-self-center">
                    <h3><i class="fas fa-users">Users</i>

                    </h3>
                </div>

{{-- 1# ini form search --}}               
            <div class="col-4">
              <form method="get" action="{{ route('dashboard.users') }}">
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
        @if(session()->has('message')){{--#2 Alert Informasi--}}
        <div class="alert alert-success" role="alert">
            <strong>{{ session()->get('message') }}</strong>
              <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
              </button>
        </div>
        @endif

        
        <div class="card-body">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Registered</th>
                    <th scope="col">Edited</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @foreach ($users AS $user)
                <tbody>
                  <tr>
                    {{-- ini pengulangan nomor urut --}}
                    <th scope="row">{{ ($users->currentPage()-1) * $users->perPage() + $loop->iteration}}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email}}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                      {{-- <a href="{{url('dashboard/user/edit/'.$user->id)}}" class="btn btn-success btn-sm" title="Edit"><i class="fas fa-pen"></i></a> --}}

                      {{-- ini perubahan route yang terbaru --}}
                    <a href="{{ route('dashboard.users.edit', ['id' => $user->id]) }}" class="btn btn-success btn-sm" title='Edit'><i class="fas fa-pen"></i></a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              {{--5# ini form search - tambahkan kode ini --}}
              {{ $users->appends($request)->links() }}
        </div>
      </div>
    

        
    @endsection