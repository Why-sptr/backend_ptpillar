<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Backend Pillar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home">Cek Ongkir</a>
                    </li>
                </ul>
                <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1> Welcome, {{ Auth::user()->name }}</h1>
    </div>

    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row center-table">
                <div class="col-lg-10 center-table grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Daftar Ongkir Ke Semua Kota</h4>
                            <p class="card-description">
                                Daftar harga ongkir terbaru
                            </p>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Data</button>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Kota Asal</th>
                                            <th>Kota Tujuan</th>
                                            <th>Kendaraan</th>
                                            <th>Harga Ongkir</th>
                                            <th class="text-center" width="300" height="10">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($db_backendpillar as $index => $ds)
                                        <tr>
                                            <td>{{ $ds->origin->origin }}</td>
                                            <td>{{ $ds->destination }}</td>
                                            <td>{{ $ds->kendaraan }}</td>
                                            <td>{{ $ds->ongkir }}</td>
                                            <td>
                                                <button type="button" style="margin-top: 10px;" class="btn btn-sec" data-bs-toggle="modal" data-bs-target="#ModalView{{$ds['id']}}">
                                                    Edit Data
                                                </button>
                                                <button type="button" style="margin-top: 10px; margin-left: 10px;" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ModalDelete{{$ds['id']}}">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .center-table {
            margin: 0 auto;
            padding-top: 20px;
        }
    </style>

    <!-- Tambah Data Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Tambah data disini</p>
                    <form action="/insertdata" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Kota Asal</label>
                            <select class="form-control select2" style="width: 100%;" name="origin" id="origin" value="{{ old('origin') }}">
                                <option disabled value>Pilih Kota Asal</option>
                                @foreach ($db_backendpillar->unique('origin_id') as $item)
                                <option value="{{ $item->origin->id }}">{{ $item->origin->origin }}</option>
                                @endforeach
                            </select>

                            @error('origin_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Kota Tujuan</label>
                                <input type="text" name="destination" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('destination') }}">
                                @error('destination')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Kendaraan</label>
                                <input type="text" name="kendaraan" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('kendaraan') }}">
                                @error('destination')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Ongkir</label>
                                <input type="text" name="ongkir" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('ongkir') }}">
                                @error('ongkir')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-secondary">Kirim</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Data Modal -->
    @foreach($db_backendpillar as $index => $ds)
    <div class="modal fade" id="ModalView{{$ds->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Ongkir</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/updatedata/{{$ds->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kota Asal</label>
                            <select class="form-control select2" style="width: 100%;" name="origin" id="origin">
                                <option disabled value>Pilih Kota Asal</option>
                                @foreach ($db_backendpillar->unique('origin_id') as $item)
                                <option value="{{ $item->origin_id }}" {{ $ds->origin_id == $item->origin_id ? 'selected' : '' }}>
                                    {{ $item->origin->origin }}
                                </option>
                                @endforeach
                            </select>
                            @error('origin')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kota Tujuan</label>
                            <input type="text" name="destination" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $ds->destination }}">
                            @error('destination')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Kendaraan</label>
                            <input type="text" name="destination" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $ds->kendaraan }}">
                            @error('kendaraan')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Harga Ongkir</label>
                            <input type="text" name="ongkir" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $ds->ongkir }}">
                            @error('ongkir')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" url="/updatedata/{id}" class="btn btn-primary">Kirim</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Delete Data -->
    @foreach($db_backendpillar as $index => $ds)
    <div id="ModalDelete{{$ds->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus Kota Tujuan <span style="font-weight: bold;">{{$ds->destination}}</span></p>
                </div>
                <div class="modal-footer">
                    <form action="/deletedata/{{$ds->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <!-- Rest of the form fields -->
                        <button type="submit" class="btn btn-danger" style="margin-top: 10px; margin-left: 10px;">Hapus</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endforeach



</body>

</html>