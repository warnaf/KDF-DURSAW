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
            <h5 class="card-title"><i class="bi bi-download"></i> Input Data Mengajar</h5>
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/mengajar">
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Mengajar</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode mengajar" required value="{{ old('id') }}">
                  @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Nama Pelajaran</label>
                <div class="col-sm-9">
                  <select class="form-select @error('id_detail_mata_pelajaran') is-invalid @enderror" aria-label="Default select example" name="id_detail_mata_pelajaran" id="id_detail_mata_pelajaran" required>
                    <option selected>pilih</option>
                    @foreach ($pelajaran as $dp)
                    @if(old('id_detail_mata_pelajaran') == $dp->id)
                      <option value="{{ $dp->id }}" >{{ $dp->nama_mata_pelajara }}</option>
                    @else 
                      <option value="{{ $dp->id }}" >{{ $dp->nama_mata_pelajara }}</option>
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
                    <option selected>pilih</option>
                    @foreach ($guru as $g)
                    @if(old('id_guru') == $g->id)
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
                  <button type="submit" class="btn btn-primary px-4" value="{{ old('body') }}">Save</button>
                  <button type="reset" class="btn btn-warning px-4">Reset</button>
                </div>
              </div>

            </form><!-- End General Form Elements -->

          </div>
        </div>

      </div>
</section>
    
@endsection