<!DOCTYPE html>
<html>
<head>
	<title>Tambah Data User</title>
</head>
<body>

	<h2>Data User</h2>

	<a href="/users"> Kembali</a>
	
	<br/>
	<br/>

	<form action="/users/store" method="post">
		Nama <input type="text" name="nama" required="required"> <br/>
        Password <input type="text" name="password" required="required"> <br/>
        Kode User <input type="text" name="kode_user" required="required"> <br/>
		Jabatan <input type="text" name="jabatan" required="required"> <br/>
        Departemen <input type="text" name="id_departemen" required="required"> <br/>
        Sub Departemen <input type="text" name="id_sub_departemen" required="required"> <br/>
		<input type="submit" value="Simpan Data">
	</form>

</body>
</html>