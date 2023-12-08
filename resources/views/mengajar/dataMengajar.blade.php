@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Data Mengajar</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Mengajar</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body table-responsive">
            <h5 class="card-title"><i class="bi bi-menu-button-wide"></i>  Data Mengajar</h5>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <a class="btn btn-primary mb-3" type="submit" href="/mengajar/create"><i class="bi bi-person-plus"></i> Tambah Data</a>
            <!-- Table with stripped rows -->
            <table class="table table-sm table-bordered datatable">
              <thead>
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Kode Mengajar</th>
                  <th scope="col" class="text-center">Mata Pelajaran</th>
                  <th scope="col" class="text-center">Nama Guru</th>
                  <th scope="col" class="text-center" width="18%">Aksi</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($dataMengajar as $mengajar)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                  <td>{{ $mengajar->id }}</td>
                  <td>{{ $mengajar->nama_mata_pelajara }}</td>
                  <td>{{ $mengajar->nama_guru }}</td>
                  <td class="text-center">
                    <a href="/mengajar/{{ $mengajar->id }}/edit" class="btn btn-sm btn-warning border-0"><span><i class="bi bi-pencil-square"></i> Edit</span></a>
                    <form action="/mengajar/{{ $mengajar->id }}" method="post" class="d-inline">
                      @method('delete')
                      @csrf
                      <button type="submit" class="btn btn-sm btn-danger border-0" onclick="return confirm('Data Akan Dihapus?')"><span><i class="bi bi-x-circle"></i> Hapus</span></button>
                    </form>
                    {{-- <a href="" class="btn btn-sm btn-danger"><span><i class="bi bi-x-circle"></i> Hapus</span></a> --}}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>
    
@endsection