@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Data Guru</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Guru</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body table-responsive">
            <h5 class="card-title"><i class="bi bi-menu-button-wide"></i>  Data Guru</h5>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <a class="btn btn-primary mb-3" type="submit" href="/guru/create"><i class="bi bi-person-plus"></i> Tambah Data</a>
            <!-- Table with stripped rows -->
            <table class="table table-sm table-bordered datatable">
              <thead>
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Kode Guru</th>
                  <th scope="col" class="text-center">Nama Guru</th>
                  <th scope="col" class="text-center">Gender</th>
                  <th scope="col" class="text-center">Department</th>
                  <th scope="col" class="text-center">Jabatan</th>
                  <th scope="col" class="text-center">Tgl Masuk</th>
                  <th scope="col" class="text-center" width="18%">Aksi</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($dataGuru as $guru)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                  <td>{{ $guru->id }}</td>
                  <td>{{ $guru->nama_guru }}</td>
                  <td>{{ $guru->jenis_kelamin }}</td>
                  <td>{{ $guru->nama_department }}</td>
                  <td>{{ $guru->jabatan }}</td>
                  <td>{{ $guru->tanggal_masuk }}</td>
                  <td class="text-center">
                    <a href="/guru/{{ $guru->id }}/edit" class="btn btn-sm btn-warning border-0"><span><i class="bi bi-pencil-square"></i> Edit</span></a>
                    <form action="/guru/{{ $guru->id }}" method="post" class="d-inline">
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