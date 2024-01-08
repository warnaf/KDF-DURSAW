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
            <h5 class="card-title"><i class="bi bi-download"></i> Input Data Kelas</h5>
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/kelas">
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Kelas</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode kelas" required value="{{ old('id') }}">
                  @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jenjang</label>
                <div class="col-sm-9">
                  <select class="form-select @error('jenjang') is-invalid @enderror" aria-label="Default select example" name="jenjang" id="jenjang" required>
                      <option value="">pilih jenjang</option>
                      <option value="7" {{ (old('jenjang')== '7') ? 'selected' : '' }}>7</option>
                      <option value="8" {{ (old('jenjang')== '8') ? 'selected' : '' }}>8</option>
                      <option value="9" {{ (old('jenjang')== '9') ? 'selected' : '' }}>9</option>
                      <option value="10" {{ (old('jenjang')== '10') ? 'selected' : '' }}>10</option>
                      <option value="11" {{ (old('jenjang')== '11') ? 'selected' : '' }}>11</option>
                      <option value="12" {{ (old('jenjang')== '12') ? 'selected' : '' }}>12</option>
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
                  <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" name="nama_kelas" id="nama_kelas" placeholder="masukan nama kelas" required value="{{ old('nama_kelas') }}">
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
                    <option value="IPA" {{ (old('jurusan')== 'IPA') ? 'selected' : '' }}>IPA</option>
                    <option value="IPS" {{ (old('jurusan')== 'IPS') ? 'selected' : '' }}>IPS</option>
                    <option value="SMP" {{ (old('jurusan')== 'SMP') ? 'selected' : '' }}>SMP</option>
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
                  <button type="submit" class="btn btn-primary px-4">Save</button>
                  <button type="reset" class="btn btn-warning px-4">Reset</button>
                </div>
              </div>

            </form><!-- End General Form Elements -->

          </div>
        </div>

      </div>
</section>
    
@endsection