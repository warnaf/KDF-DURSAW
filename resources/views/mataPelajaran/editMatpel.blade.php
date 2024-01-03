@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Form Mata Pelajaran</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">MatPel</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-download"></i> Edit Data Mata Pelajaran</h5>
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/matpel/{{ $id }}">
              @method('put')
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Matpel</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode mata pelajaran" required value="{{ old('id', $id) }}" readonly>
                  {{-- @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror --}}
                </div>
              </div>
              <div class="row mb-3">
                <label for="nama_mata_pelajara" class="col-sm-2 col-form-label">Nama Matpel</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('nama_mata_pelajara') is-invalid @enderror" name="nama_mata_pelajara" id="nama_mata_pelajara" placeholder="masukan mata pelajaran" required value="{{ old('nama_mata_pelajara',  $nama_mata_pelajara) }}">
                  @error('nama_mata_pelajara')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="is_penjuruan" class="col-sm-2 col-form-label">Penjuruan</label>
                <div class="col-sm-9">
                  <select class="form-select @error('is_penjuruan') is-invalid @enderror" aria-label="Default select example" name="is_penjuruan" id="is_penjuruan" required>
                    <option selected value="0" {{ ($is_penjuruan== '0') ? 'selected' : '' }}>No</option>
                    <option value="1" {{ ($is_penjuruan== '1') ? 'selected' : '' }}>Yes</option>
                  </select>
                  @error('is_penjuruan')
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