<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Indie Haus - Login</title>

	<style>
		table{
			height:100vh;
			display:grid;
			place-content: center;
		}
		table th{
			font-size: 14pt;
			font-variant: small-caps;
		}
		table tr td{
			padding:5px;
		}
		button{
			float: right;
		}
	</style>
</head>
<body>

	<form method = "post" action = "login.php">
		<table>
			<tr>
				<th colspan="2">Indie Haus</th>
			</tr>
			<tr>
				<td colspan="2">
					<select name="role" class="form-control" required>
						<option value="">-- Select role --</option>
						<option value="Developer">Developer</option>
						<option value="Tester">Tester</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" name="name" placeholder="Name" class="form-control" required>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="password" name="password" placeholder="Password" class="form-control" required>
				</td>
			</tr>
			<tr>
				<td>
					<a href = "register.php" class="btn btn-link">Register</a>
				</td>
				<td>
					<button name = "login_btn" class="btn btn-primary">Login</button>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>