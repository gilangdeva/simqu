<!DOCTYPE html>
<html>
<head>
	<title>Data User</title>
</head>
<body>

	<h2>Data User</h2>

	<a href="/users/adduser"> + Tambah User Baru</a>
	
	<br/>
	<br/>

	<table border="1">
		<tr>
			<th>Nama</th>
			<th>Password</th>
			<th>Opsi</th>
		</tr>
		@foreach($users as $u)
		<tr>
			<td>{{ $u->nama_user }}</td>
			<td>{{ $u->password }}</td>
			<td>
				<a href="/users/edit_user/{{ $u->id_user }}">Edit</a>
				|
				<a href="/users/delete_user/{{ $u->id_user }}">Hapus</a>
			</td>
		</tr>
		@endforeach
	</table>


</body>
</html>