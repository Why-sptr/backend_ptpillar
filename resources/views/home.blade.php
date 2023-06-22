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
            <a class="nav-link active" aria-current="page" href="/data">Tambah Data</a>
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

  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h3>Cek Ongkir</h3>
          </div>
          <div class="card-body">
            <form id="form">
              <div class="form-group">
                <label for="">Kota Asal</label>
                <select class="form-control select2" style="width: 100%;" name="origin" id="origin" value="{{ old('origin') }}">
                  <option disabled value>Pilih Kota Asal</option>
                  @foreach ($db_backendpillar->unique('origin_id') as $item)
                  <option value="{{ $item->origin->id }}">{{ $item->origin->origin }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="">Kendaraan</label>
                <select class="form-control select2" style="width: 100%;" name="kendaraan" id="kendaraan" value="{{ old('kendaraan') }}">
                  <option disabled value>Kendaraan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Kota Tujuan</label>
                <select class="form-control select2" style="width: 100%;" name="origin_id" id="origin_id" value="{{ old('origin_id') }}">
                  <option disabled value>Pilih Kota Tujuan</option>
                </select>
              </div>
              <button class="btn btn-sm btn-primary" style="margin-top:20px">Submit</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h3>Biaya Ongkir</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Kota Asal</th>
                    <th>Kota Tujuan</th>
                    <th>Harga</th>
                  </tr>
                </thead>
                <!-- DATA ONGKIR AKAN DITAMPILKAN DISINI  -->
                <tbody id="data_table">
                <div id="result" style="margin-top: 20px;"></div>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
 var destinations = {!! json_encode($db_backendpillar) !!};

document.getElementById('origin').addEventListener('change', function() {
  var originId = this.value;
  var kendaraanSelect = document.getElementById('kendaraan');
  kendaraanSelect.innerHTML = '<option disabled value>Kendaraan</option>';

  var filteredDestinations = destinations.filter(function(item) {
    return item.origin_id == originId;
  });

  var addedKendaraan = []; // Menyimpan kendaraan yang sudah ditambahkan

  filteredDestinations.forEach(function(item) {
    if (!addedKendaraan.includes(item.kendaraan)) {
      var option = document.createElement('option');
      option.value = item.kendaraan;
      option.textContent = item.kendaraan;
      kendaraanSelect.appendChild(option);
      
      addedKendaraan.push(item.kendaraan); // Tambahkan kendaraan ke daftar yang sudah ditambahkan
    }
  });

  // Reset Kota Tujuan saat mengubah Kota Asal
  var destinationSelect = document.getElementById('origin_id');
  destinationSelect.innerHTML = '<option disabled value>Pilih Kota Tujuan</option>';
});

document.getElementById('kendaraan').addEventListener('change', function() {
  var kendaraan = this.value;
  var originId = document.getElementById('origin').value;
  var destinationSelect = document.getElementById('origin_id');
  destinationSelect.innerHTML = '<option disabled value>Pilih Kota Tujuan</option>';

  var filteredDestinations = destinations.filter(function(item) {
    return item.kendaraan == kendaraan && item.origin_id == originId;
  });

  filteredDestinations.forEach(function(item) {
    var option = document.createElement('option');
    option.value = item.id;
    option.textContent = item.destination;
    option.setAttribute('data-ongkir', item.ongkir);
    destinationSelect.appendChild(option);
  });
});



  document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault();
    var selectedDestination = document.getElementById('origin_id');
    var selectedOption = selectedDestination.options[selectedDestination.selectedIndex];
    var ongkir = selectedOption.getAttribute('data-ongkir');
    var origin = document.getElementById('origin').options[document.getElementById('origin').selectedIndex].text;
    var destination = selectedDestination.options[selectedDestination.selectedIndex].text;

    var newRow = document.createElement('tr');
    newRow.innerHTML = '<td>' + origin + '</td><td>' + destination + '</td><td>' + ongkir + '</td>';
    document.getElementById('data_table').appendChild(newRow);
  });
</script>


</body>

</html>