@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Form Detail Pelajaran</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Detail Matpel</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-download"></i> Edit Data Detail Pelajaran</h5>
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/detailMatpel/{{ $id }}">
              @method('put')
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Pelajaran</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode pelajaran" required value="{{ old('id', $id) }}" readonly>
                  {{-- @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror --}}
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Pelajaran</label>
                <div class="col-sm-9">
                  <select class="form-select @error('mata_pelajaran_ref') is-invalid @enderror" aria-label="Default select example" name="mata_pelajaran_ref" id="mata_pelajaran_ref" required>
                    <option selected>pilih</option>
                    @foreach ($mata_pelajaran as $mp)
                    @if(old('mata_pelajaran_ref', $mata_pelajaran_ref) == $mp->id)
                      <option value="{{ $mp->id }}" selected>{{ $mp->nama_mata_pelajara }}</option>
                    @else 
                      <option value="{{ $mp->id }}" >{{ $mp->nama_mata_pelajara }}</option>
                    @endif 
                    @endforeach
                  </select>
                  @error('mata_pelajaran_ref')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="jumlah_jam" class="col-sm-2 col-form-label">Jumlah Jam</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('jumlah_jam') is-invalid @enderror" name="jumlah_jam" id="jumlah_jam" placeholder="isi jumlah jam pelajaran" required value="{{ old('jumlah_jam', $jumlah_jam) }}">
                  @error('jumlah_jam')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="max_jam" class="col-sm-2 col-form-label">Maksimal Jam</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('max_jam') is-invalid @enderror" name="max_jam" id="max_jam" placeholder="isi jumlah maksimal jam pelajaran" required value="{{ old('max_jam', $max_jam) }}">
                  @error('max_jam')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              
              <div class="row mb-3">
                <label for="semester" class="col-sm-2 col-form-label">Semester</label>
                <div class="col-sm-9">
                  <select class="form-select @error('semester') is-invalid @enderror" aria-label="Default select example" name="semester" id="semester" required>
                    <option selected>pilih</option>
                      <option value="1" {{ ($semester == '1') ? 'selected' : '' }}>1</option>
                      <option value="2" {{ ($semester == '2') ? 'selected' : '' }}>2</option>
                </select>
                  @error('semester')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                <div class="col-sm-9">
                  <select class="form-select @error('jenjang') is-invalid @enderror" aria-label="Default select example" name="jenjang" id="jenjang" required>
                    <option selected>pilih</option>
                    <option value="7" {{ ($jenjang == '7') ? 'selected' : '' }}>7</option>
                    <option value="8" {{ ($jenjang == '8') ? 'selected' : '' }}>8</option>
                    <option value="9" {{ ($jenjang == '9') ? 'selected' : '' }}>9</option>
                    <option value="10" {{ ($jenjang == '10') ? 'selected' : '' }}>10</option>
                    <option value="11" {{ ($jenjang == '11') ? 'selected' : '' }}>11</option>
                    <option value="12" {{ ($jenjang == '12') ? 'selected' : '' }}>12</option>
                </select>
                  @error('jenjang')
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