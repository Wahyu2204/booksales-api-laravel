<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang</title>
</head>
<body>
  <h1>Ini adalah halaman genre buku</h1>

  <!-- Manggil data dari GenreController -->
  @foreach ($genres as $item)
    <ul>
      <li>{{ $item['name'] }}</li>
      <li>{{ $item['description'] }}</li>
    </ul>
  @endforeach
</body>
</html>