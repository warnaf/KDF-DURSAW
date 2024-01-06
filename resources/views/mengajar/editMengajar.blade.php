@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Form Mengajar</h1>
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
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-download"></i> Edit Data Mengajar</h5>
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/mengajar/{{ $mengajar->id }}">
              @method('put')
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Mengajar</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode mengajar" required value="{{ old('id', $mengajar->id) }}" readonly>
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
                  <select class="form-select @error('id_detail_mata_pelajaran') is-invalid @enderror" aria-label="Default select example" name="id_detail_mata_pelajaran" id="id_detail_mata_pelajaran" required>
                    <option value="">pilih</option>
                    @foreach ($detail_pelajaran as $mp)
                    @if(old('id_detail_mata_pelajaran', $mengajar->id_detail_mata_pelajaran) == $mp->id)
                      <option value="{{ $mp->id }}" selected>{{ $mp->nama_mata_pelajara }} {{ $mp->jenjang }}</option>
                    @else 
                      <option value="{{ $mp->id }}" >{{ $mp->nama_mata_pelajara }} {{ $mp->jenjang }}</option>
                    @endif 
                    @endforeach
                  </select>
                  @error('id_detail_mata_pelajaran')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Guru</label>
                <div class="col-sm-9">
                  <select class="form-select @error('id_guru') is-invalid @enderror" aria-label="Default select example" name="id_guru" id="id_guru" required>
                    <option value="">pilih</option>
                    @foreach ($guru as $g)
                    @if(old('id_guru', $mengajar->id_guru) == $g->id)
                      <option value="{{ $g->id }}" selected>{{ $g->nama_guru }}</option>
                    @else 
                      <option value="{{ $g->id }}" >{{ $g->nama_guru }}</option>
                    @endif 
                    @endforeach
                  </select>
                  @error('id_guru')
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