@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Form Department</h1>
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
            <h5 class="card-title"><i class="bi bi-download"></i> Edit Data Department</h5>
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/department/{{ $id }}">
              @method('put')
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Kelas</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode kelas" required value="{{ old('id', $id) }}" readonly>
                  {{-- @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror --}}
                </div>
              </div>
              <div class="row mb-3">
                <label for="nama_department" class="col-sm-2 col-form-label">Nama Department</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('nama_department') is-invalid @enderror" name="nama_department" id="nama_department" placeholder="masukan nama department" required value="{{ old('nama_department',  $nama_department) }}">
                  @error('nama_department')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-6 mt-2">
                  <button type="submit" class="btn btn-primary px-4">Edit</button>
                  <button type="reset" class="btn btn-warning px-4">Reset</button>
                </div>
              </div>

            </form><!-- End General Form Elements -->

          </div>
        </div>

      </div>
</section>
    
@endsection