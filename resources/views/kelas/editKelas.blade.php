@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Form Kelas</h1>
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
            <h5 class="card-title"><i class="bi bi-download"></i> Edit Data Kelas</h5>
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/kelas/{{ $data->id }}">
              @method('put')
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Kelas</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode kelas" required value="{{ old('id', $data->id) }}" readonly>
                  {{-- @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror --}}
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jenjang</label>
                <div class="col-sm-9">
                  <select class="form-select @error('jenjang') is-invalid @enderror" aria-label="Default select example" name="jenjang" id="jenjang" required>
                    <option value="">pilih jenjang</option>
                    <option value="7" {{ ($data->jenjang== '7') ? 'selected' : '' }}>7</option>
                    <option value="8" {{ ($data->jenjang== '8') ? 'selected' : '' }}>8</option>
                    <option value="9" {{ ($data->jenjang== '9') ? 'selected' : '' }}>9</option>
                    <option value="10" {{ ($data->jenjang== '10') ? 'selected' : '' }}>10</option>
                    <option value="11" {{ ($data->jenjang== '11') ? 'selected' : '' }}>11</option>
                    <option value="12" {{ ($data->jenjang== '12') ? 'selected' : '' }}>12</option>
                  </select>
                  @error('jenjang')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="nama_kelas" class="col-sm-2 col-form-label">Nama Kelas</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" id="nama_kelas" placeholder="masukan nama kelas" required value="{{ old('nama_kelas',  $data->nama_kelas) }}">
                  @error('nama_kelas')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jurusan</label>
                <div class="col-sm-9">
                  <select class="form-select @error('jurusan') is-invalid @enderror" aria-label="Default select example" name="jurusan" id="jurusan" required>
                    <option value="">pilih jurusan</option>
                    <option value="IPA" {{ ($data->jurusan== 'IPA') ? 'selected' : '' }}>IPA</option>
                    <option value="IPS" {{ ($data->jurusan== 'IPS') ? 'selected' : '' }}>IPS</option>
                    <option value="SMP" {{ ($data->jurusan== 'SMP') ? 'selected' : '' }}>SMP</option>
                  </select>
                  @error('jurusan')
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