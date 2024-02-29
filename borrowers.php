<?php 
include ('db_connect.php');

if ($_SESSION['login_type'] == 2) {
	$logged_in_user = $_SESSION['login_name'];
	$user_query = $conn->query("SELECT * FROM users WHERE name = '$logged_in_user'");
	
	if ($user_query === false) {
		die('Query Error: ' . $conn->error);
	}
	
	$user = $user_query->fetch_assoc();
	
	if (!$user) {
		die('User not found');
	}
	
	$tax_id = $user['tax_id'];
}

?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Borrower List</b>
				</large>
				<button class="btn btn-primary btn-block col-md-2 float-right" type="button" id="new_borrower">
					<i class="fa fa-plus"></i> New Borrower
				</button>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="borrower-list">
					<colgroup>
						<col width="10%">
						<col width="35%">
						<col width="15%">
						<col width="20%">
						<col width="20%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Borrower</th>
							<th class="text-center">Current Loans</th>
							<th class="text-center">Next Payment Schedule</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						if ($_SESSION['login_type'] == 2) {
							$qry = $conn->query("SELECT * FROM borrowers WHERE tax_id = '$tax_id' ORDER BY id DESC");
						} elseif ($_SESSION['login_type'] == 1) {
							$qry = $conn->query("SELECT * FROM borrowers ORDER BY id DESC");
						}
						
						while ($row = $qry->fetch_assoc()):
							// Display borrower details
							$borrower_id = $row['id'];
							$loan_query = $conn->query("SELECT COUNT(*) AS loan_count FROM loan_list WHERE borrower_id = '$borrower_id'");
							$loan_count = $loan_query->fetch_assoc()['loan_count'];
							
							$loan_schedule_query = $conn->query("SELECT MIN(date_due) AS next_payment FROM loan_schedules WHERE loan_id IN (SELECT id FROM loan_list WHERE borrower_id = '$borrower_id')");
							$next_payment = $loan_schedule_query->fetch_assoc()['next_payment'];
							$next_payment = $next_payment ? date('Y-m-d', strtotime($next_payment)) : 'N/A';
						 ?>
						 <tr>
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<p>Name: <b><?php echo ucwords($row['lastname'].", ".$row['firstname'].' '.$row['middlename']) ?></b></p>
						 		<p><small>Address: <b><?php echo $row['address'] ?></small></b></p>
						 		<p><small>Contact #: <b><?php echo $row['contact_no'] ?></small></b></p>
						 		<p><small>Email: <b><?php echo $row['email'] ?></small></b></p>
						 		<p><small>Tax ID: <b><?php echo $row['tax_id'] ?></small></b></p>
						 	</td>
						 	<td class="text-center"><?php echo $loan_count ?></td>
						 	<td class="text-center"><?php echo $next_payment ?></td>
						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_borrower" type="button" data-id="<?php echo $row['id'] ?>">
						 				<i class="fa fa-edit"></i>
						 			</button>
						 			<button class="btn btn-outline-danger btn-sm delete_borrower" type="button" data-id="<?php echo $row['id'] ?>">
						 				<i class="fa fa-trash"></i>
						 			</button>
						 	</td>
						 </tr>
					
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#borrower-list').dataTable()
	$('#new_borrower').click(function(){
		uni_modal("New borrower","manage_borrower.php",'mid-large')
	})
	$('.edit_borrower').click(function(){
		uni_modal("Edit borrower","manage_borrower.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_borrower').click(function(){
		_conf("Are you sure to delete this borrower?","delete_borrower",[$(this).attr('data-id')])
	})
function delete_borrower($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_borrower',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("borrower successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>