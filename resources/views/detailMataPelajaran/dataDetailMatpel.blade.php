@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Data Detail Pelajaran</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Pelajaran</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body table-responsive">
            <h5 class="card-title"><i class="bi bi-menu-button-wide"></i>  Data Detail Pelajaran</h5>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <a class="btn btn-primary mb-3" type="submit" href="/detailMatpel/create"><i class="bi bi-person-plus"></i> Tambah Data</a>
            <!-- Table with stripped rows -->
            <table class="table table-sm table-bordered datatable">
              <thead>
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Kode Pelajaran</th>
                  <th scope="col" class="text-center">Pelajaran</th>
                  <th scope="col" class="text-center">Jam</th>
                  <th scope="col" class="text-center">Max Jam</th>
                  <th scope="col" class="text-center">Smt</th>
                  <th scope="col" class="text-center">Jenjang</th>
                  <th scope="col" class="text-center" width="18%">Aksi</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($dataDetailMatpel as $dMatpel)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                  <td>{{ $dMatpel->id }}</td>
                  <td>{{ $dMatpel->nama_mata_pelajara }}</td>
                  <td>{{ $dMatpel->jumlah_jam }}</td>
                  <td>{{ $dMatpel->max_jam }}</td>
                  <td>{{ $dMatpel->semester }}</td>
                  <td>{{ $dMatpel->jenjang }}</td>
                  <td class="text-center">
                    <a href="/detailMatpel/{{ $dMatpel->id }}/edit" class="btn btn-sm btn-warning border-0"><span><i class="bi bi-pencil-square"></i> Edit</span></a>
                    <form action="/detailMatpel/{{ $dMatpel->id }}" method="post" class="d-inline">
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