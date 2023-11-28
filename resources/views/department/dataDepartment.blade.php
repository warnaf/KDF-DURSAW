@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Data Department</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Department</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-menu-button-wide"></i>  Data Department</h5>
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <a class="btn btn-primary mb-3" type="submit" href="/department/create"><i class="bi bi-person-plus"></i> Tambah Data</a>
            <!-- Table with stripped rows -->
            <table class="table table-bordered datatable">
              <thead>
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Kode Department</th>
                  <th scope="col" class="text-center">Nama Department</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody> 
                @foreach ($dataDepartment as $department)
                <tr>
                  <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                  <td>{{ $department->id }}</td>
                  <td>{{ $department->nama_department }}</td>
                  <td class="text-center">
                    <a href="/department/{{ $department->id }}/edit" class="btn btn-sm btn-warning"><span><i class="bi bi-pencil-square"></i> Edit</span></a>
                    <form action="/department/{{ $department->id }}" method="post" class="d-inline">
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