<!DOCTYPE html>
<html>
<head>
	<title>Admin - show all learners invoices</title>
</head>
<style type="text/css">
		body {
		font-family: Courier;
	}
	ul {
		background-color: #f3f3f3;
		padding: 1%; 
		overflow-x:hidden;
		white-space:nowrap; 
		height: 1em;
		width: 80%;
	} 
	li { 
		display:inline; 
	}
	a {
		color:black;
	}
	#body {
		margin-left: 10%;
		margin-right: 10%;
	}
	#course {
		border: 1px solid black;
		padding: 2%;
	}
	table, td, th {
		border: 1px solid black;
	} 
</style>
<body>
	<table>
		<tr>
			<td>User</td>
			<td>Email</td>
			<td>Address</td>
			<td>Phone</td>
			<td>Status</td>
			<td>Sended</td>
			<td>Subject</td>
			<td>Created at</td>
			<td>Accepted at</td>
			<td>Images</td>
		</tr>
		<? foreach($invoices as $invoice): ?>
			<tr>
				<td><a href="<? echo $this->url('p').'/'.$invoice->userId; ?>"><? echo strip_tags($invoice->firstname." ".$invoice->lastname); ?></a></td>
				<td><? echo strip_tags($invoice->address); ?>
				<td><? echo strip_tags($invoice->email); ?></td>
				<td><? echo strip_tags($invoice->phone); ?></td>
				<td><? echo strip_tags($invoice->status); ?></td>
				<td><? echo strip_tags($invoice->sended); ?></td>
				<td><? echo strip_tags($invoice->subject); ?></td>
				<td><? echo strip_tags($invoice->created_at); ?></td>
				<td><? echo strip_tags($invoice->modified_at); ?></td>
				<td><li>Image 1 : <a href="<? echo $this->url('getImage/'.$invoice->image1); ?>"><? echo $invoice->image1; ?></a></li>
				<br/>
				<li>Image 2 : <a href="<? echo $this->url('getImage/'.$invoice->image2); ?>"><? echo $invoice->image2; ?></a></li>
				<br/>
				<li>Image 3 : <a href="<? echo $this->url('getImage/'.$invoice->image3); ?>"><? echo $invoice->image3; ?></a></li>
				<br/>
				<li>ID : <a href="<? echo $this->url('getImage/'.$invoice->id); ?>"><? echo $invoice->id; ?></a></li></td>
			</tr>
		<? endforeach; ?>			
	</table>
</body>
</html>
