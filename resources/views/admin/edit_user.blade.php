<!DOCTYPE html>
<html>
<head>
	<title>Edit Data User</title>
</head>
<body>

	<h2>Edit Data User</h2>

	<a href="/users"> Kembali</a>
	
	<br/>
	<br/>

	@foreach($users as $u)
	<form action="/users/update" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $u->id_user }}"> <br/>
		Nama <input type="text" name="nama" required="required" value="{{ $u->nama_user }}"> <br/>
        Password <input type="text" name="password" required="required" value="{{ $u->password }}" > <br/>
        Kode User <input type="text" name="kode_user" required="required" value="{{ $u->kode_user }}" > <br/>
		Jabatan <input type="text" name="jabatan" required="required" value="{{ $u->jenis_user }}"> <br/>
        Departemen <input type="text" name="id_departemen" required="required" value="{{ $u->id_departemen }}"> <br/>
        Sub Departemen <input type="text" name="id_sub_departemen" required="required" value="{{ $u->id_sub_departemen }}"> <br/>
		<input type="submit" value="Simpan Data">
	</form>
	@endforeach
		

</body>
</html>