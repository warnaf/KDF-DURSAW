@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Data Kelas</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Kelas</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-menu-button-wide"></i>  Data Kelas</h5>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <a class="btn btn-primary mb-3" type="submit" href="/kelas/create"><i class="bi bi-person-plus"></i> Tambah Data</a>
            <!-- Table with stripped rows -->
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Kode Kelas</th>
                  <th scope="col" class="text-center">Jenjang</th>
                  <th scope="col" class="text-center">Nama Kelas</th>
                  <th scope="col" class="text-center">Jurusan</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($dataKelas as $kelas)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                  <td>{{ $kelas->id }}</td>
                  <td>{{ $kelas->jenjang }}</td>
                  <td>{{ $kelas->nama_kelas }}</td>
                  <td>{{ $kelas->jurusan }}</td>
                  <td class="text-center">
                    <a href="/kelas/{{ $kelas->id }}/edit" class="btn btn-sm btn-warning"><span><i class="bi bi-pencil-square"></i> Edit</span></a>
                    <form action="/kelas/{{ $kelas->id }}" method="post" class="d-inline">
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