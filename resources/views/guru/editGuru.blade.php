@extends('layouts.main')

@section('main')

<div class="pagetitle">
    <h1>Form Guru</h1>
    <nav class="d-flex justify-content-end">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item">Guru</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="bi bi-download"></i> Edit Data Guru</h5>
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <hr>
            <!-- General Form Elements -->
            <form class="mt-4" method="post" action="/guru/{{ $guru->id }}">
              @method('put')
              @csrf
              <div class="row mb-3">
                <label for="id" class="col-sm-2 col-form-label">Kode Guru</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('id') is-invalid @enderror" name="id" id="id" placeholder="masukan kode guru" required value="{{ old('id', $guru->id) }}" readonly>
                  {{-- @error('id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror --}}
                </div>
              </div>
              <div class="row mb-3">
                <label for="nama_guru" class="col-sm-2 col-form-label">Nama Guru</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" name="nama_guru" id="nama_guru" placeholder="masukan nama guru" required value="{{ old('nama_guru', $guru->nama_guru) }}">
                  @error('nama_guru')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-9">
                  <select class="form-select @error('jenis_kelamin') is-invalid @enderror" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required>
                      <option selected>pilih</option>
                      <option value="L" {{ ($guru->jenis_kelamin == 'L') ? 'selected' : '' }}>Laki - laki</option>
                      <option value="P" {{ ($guru->jenis_kelamin == 'P') ? 'selected' : '' }}>Perempuan</option>
                  </select>
                  @error('jenis_kelamin')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Department</label>
                <div class="col-sm-9">
                  <select class="form-select @error('department_id') is-invalid @enderror" aria-label="Default select example" name="department_id" id="department_id" required>
                    <option selected>pilih</option>
                    @foreach ($departments as $d)
                    @if(old('department_id', $guru->department_id) == $d->id)
                      <option value="{{ $d->id }}" selected>{{ $d->nama_department }}</option>
                    @else 
                      <option value="{{ $d->id }}" >{{ $d->nama_department }}</option>
                    @endif 
                    @endforeach
                  </select>
                  @error('department_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-9">
                  <select class="form-select @error('jabatan') is-invalid @enderror" aria-label="Default select example" name="jabatan" id="jabatan" required>
                    <option selected>pilih</option>
                    <option value="Principal" {{ ($guru->jabatan == 'Principal') ? 'selected' : '' }}>Principal</option>
                    <option value="Counselor" {{ ($guru->jabatan == 'Counselor') ? 'selected' : '' }}>Counselor</option>
                    <option value="School_Coordinator" {{ ($guru->jabatan == 'School_Coordinator') ? 'selected' : '' }}>School_Coordinator</option>
                    <option value="Homeroom" {{ ($guru->jabatan == 'Homeroom') ? 'selected' : '' }}>Homeroom</option>
                    <option value="Head_of_department" {{ ($guru->jabatan == 'Head_of_department') ? 'selected' : '' }}>Head_of_department</option>
                    <option value="Science_Lab_Coordinator" {{ ($guru->jabatan == 'Science_Lab_Coordinator') ? 'selected' : '' }}>Science_Lab_Coordinator</option>
                    <option value="Lab_Assistant" {{ ($guru->jabatan == 'Lab_Assistant') ? 'selected' : '' }}>Lab_Assistant</option>
                </select>
                  @error('jabatan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="tanggal_masuk" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" name="tanggal_masuk" id="tanggal_masuk" placeholder="masukan tanggal_masuk" required value="{{ old('tanggal_masuk', $guru->tanggal_masuk) }}">
                  @error('tanggal_masuk')
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