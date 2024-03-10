<?php
include('db_connect.php');

$qry = $conn->query("SELECT * FROM loan_list");
$loans = $qry->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Loans Report</b>
				</large>
			</div>
			<div class="card-body">
				<button class="btn btn-primary generate-report-btn" data-report="loans">Generate Report</button>
				<table class="table table-bordered" id="loans-report" style="display: none;">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Borrower</th>
							<th class="text-center">Loan Amount</th>
							<th class="text-center">Date Released</th>
                            <th class="text-center">Date Created</th>
							<th class="text-center">Loan Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($loans as $loan):
							$borrower_id = $loan['borrower_id'];
							$borrower_query = $conn->query("SELECT * FROM borrowers WHERE id = '$borrower_id'");
							$borrower = $borrower_query->fetch_assoc();
						?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td><?php echo $borrower['firstname'] . ' ' . $borrower['lastname'] ?></td>
							<td class="text-center"><?php echo $loan['amount'] ?></td>
							<td class="text-center"><?php echo $loan['date_released'] ?></td>
                            <td class="text-center"><?php echo $loan['date_created'] ?></td>
							<td class="text-center"><?php echo $loan['status'] ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	// Function to generate the loans report
	function generateLoansReport() {
		// Retrieve the table element
		var table = document.getElementById("loans-report");

		// Show the table
		table.style.display = "table";

		// Create an empty array to store the report data
		var reportData = [];

		// Iterate over each row in the table (skipping the header row)
		for (var i = 1; i < table.rows.length; i++) {
			// Create an object to store the data for each row
			var rowData = {};

			// Iterate over each cell in the row
			for (var j = 0; j < table.rows[i].cells.length; j++) {
				// Get the column header from the table header row
				var columnHeader = table.rows[0].cells[j].textContent;

				// Get the cell value from the current row
				var cellValue = table.rows[i].cells[j].textContent;

				// Add the data to the rowData object using the column header as the key
				rowData[columnHeader] = cellValue;
			}

			// Add the rowData object to the reportData array
			reportData.push(rowData);
		}

		// Log the report data to the console
		console.log('Loans Report Data:', reportData);
	}

	// Add click event listener to the "Generate Report" button
	document.querySelector('.generate-report-btn[data-report="loans"]').addEventListener('click', function() {
		generateLoansReport();
	});
</script>
<?php
include('db_connect.php');

$qry = $conn->query("SELECT * FROM payments");
$payments = $qry->fetch_all(MYSQLI_ASSOC);

?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Payment Report</b>
				</large>
			</div>
			<div class="card-body">
				<button class="btn btn-primary generate-report-btn" data-report="payments">Generate Report</button>
				<table class="table table-bordered" id="payment-report" style="display: none;">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Borrower</th>
							<th class="text-center">Loan ID</th>
							<th class="text-center">Payment Amount</th>
							<th class="text-center">Payment Date</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($payments as $payment):
							$loan_id = $payment['loan_id'];
							$loan_query = $conn->query("SELECT * FROM loan_list WHERE id = '$loan_id'");
							$loan = $loan_query->fetch_assoc();
							$borrower_id = $loan['borrower_id'];
							$borrower_query = $conn->query("SELECT * FROM borrowers WHERE id = '$borrower_id'");
							$borrower = $borrower_query->fetch_assoc();
						?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td><?php echo $borrower['firstname'] . ' ' . $borrower['lastname'] ?></td>
							<td class="text-center"><?php echo $loan_id ?></td>
							<td class="text-center"><?php echo $payment['amount'] ?></td>
							<td class="text-center"><?php echo $payment['date_created'] ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	// Function to generate the payment report
	function generatePaymentReport() {
		// Retrieve the table element
		var table = document.getElementById("payment-report");

		// Show the table
		table.style.display = "table";

		// Create an empty array to store the report data
		var reportData = [];

		// Iterate over each row in the table (skipping the header row)
		for (var i = 1; i < table.rows.length; i++) {
			// Create an object to store the data for each row
			var rowData = {};

			// Iterate over each cell in the row
			for (var j = 0; j < table.rows[i].cells.length; j++) {
				// Get the column header from the table header row
				var columnHeader = table.rows[0].cells[j].textContent;

				// Get the cell value from the current row
				var cellValue = table.rows[i].cells[j].textContent;

				// Add the data to the rowData object using the column header as the key
				rowData[columnHeader] = cellValue;
			}

			// Add the rowData object to the reportData array
			reportData.push(rowData);
		}

		// Log the report data to the console
		console.log('Payment Report Data:', reportData);
	}

	// Add click event listener to the "Generate Report" button
	document.querySelector('.generate-report-btn[data-report="payments"]').addEventListener('click', function() {
		generatePaymentReport();
	});
</script>

<?php
include('db_connect.php');

$qry = $conn->query("SELECT * FROM borrowers");
$borrowers = $qry->fetch_all(MYSQLI_ASSOC);
?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Borrowers Report</b>
				</large>
			</div>
			<div class="card-body">
				<button class="btn btn-primary generate-report-btn" data-report="borrowers">Generate Report</button>
				<table class="table table-bordered" id="borrowers-report" style="display: none;">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">Phone</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($borrowers as $borrower):
						?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td><?php echo $borrower['firstname'] . ' ' . $borrower['lastname'] ?></td>
							<td class="text-center"><?php echo $borrower['email'] ?></td>
							<td class="text-center"><?php echo $borrower['contact_no'] ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	// Function to generate the borrowers report
	function generateBorrowersReport() {
		// Retrieve the table element
		var table = document.getElementById("borrowers-report");

		// Show the table
		table.style.display = "table";

		// Create an empty array to store the report data
		var reportData = [];

		// Iterate over each row in the table (skipping the header row)
		for (var i = 1; i < table.rows.length; i++) {
			// Create an object to store the data for each row
			var rowData = {};

			// Iterate over each cell in the row
			for (var j = 0; j < table.rows[i].cells.length; j++) {
				// Get the column header from the table header row
				var columnHeader = table.rows[0].cells[j].textContent;

				// Get the cell value from the current row
				var cellValue = table.rows[i].cells[j].textContent;

				// Add the data to the rowData object using the column header as the key
				rowData[columnHeader] = cellValue;
			}

			// Add the rowData object to the reportData array
			reportData.push(rowData);
		}

		// Log the report data to the console
		console.log('Borrowers Report Data:', reportData);
	}

	// Add click event listener to the "Generate Report" button
	document.querySelector('.generate-report-btn[data-report="borrowers"]').addEventListener('click', function() {
		generateBorrowersReport();
	});
</script>

<script>
	// Function to generate the loans report
	function generateLoansReport() {
		// Retrieve the table element
		var table = document.getElementById("loans-report");

		// Show the table
		table.style.display = "table";

		// Create an empty array to store the report data
		var reportData = [];

		// Iterate over each row in the table (skipping the header row)
		for (var i = 1; i < table.rows.length; i++) {
			// Create an object to store the data for each row
			var rowData = {};

			// Iterate over each cell in the row
			for (var j = 0; j < table.rows[i].cells.length; j++) {
				// Get the column header from the table header row
				var columnHeader = table.rows[0].cells[j].textContent;

				// Get the cell value from the current row
				var cellValue = table.rows[i].cells[j].textContent;

				// Add the data to the rowData object using the column header as the key
				rowData[columnHeader] = cellValue;
			}

			// Add the rowData object to the reportData array
			reportData.push(rowData);
		}

		// Log the report data to the console
		console.log('Loans Report Data:', reportData);

		// Print the report
		printReport(table);
	}

	// Function to generate the payment report
	function generatePaymentReport() {
		// Retrieve the table element
		var table = document.getElementById("payment-report");

		// Show the table
		table.style.display = "table";

		// Create an empty array to store the report data
		var reportData = [];

		// Iterate over each row in the table (skipping the header row)
		for (var i = 1; i < table.rows.length; i++) {
			// Create an object to store the data for each row
			var rowData = {};

			// Iterate over each cell in the row
			for (var j = 0; j < table.rows[i].cells.length; j++) {
				// Get the column header from the table header row
				var columnHeader = table.rows[0].cells[j].textContent;

				// Get the cell value from the current row
				var cellValue = table.rows[i].cells[j].textContent;

				// Add the data to the rowData object using the column header as the key
				rowData[columnHeader] = cellValue;
			}

			// Add the rowData object to the reportData array
			reportData.push(rowData);
		}

		// Log the report data to the console
		console.log('Payment Report Data:', reportData);

		// Print the report
		printReport(table);
	}

	// Function to generate the borrowers report
	function generateBorrowersReport() {
		// Retrieve the table element
		var table = document.getElementById("borrowers-report");

		// Show the table
		table.style.display = "table";

		// Create an empty array to store the report data
		var reportData = [];

		// Iterate over each row in the table (skipping the header row)
		for (var i = 1; i < table.rows.length; i++) {
			// Create an object to store the data for each row
			var rowData = {};

			// Iterate over each cell in the row
			for (var j = 0; j < table.rows[i].cells.length; j++) {
				// Get the column header from the table header row
				var columnHeader = table.rows[0].cells[j].textContent;

				// Get the cell value from the current row
				var cellValue = table.rows[i].cells[j].textContent;

				// Add the data to the rowData object using the column header as the key
				rowData[columnHeader] = cellValue;
			}

			// Add the rowData object to the reportData array
			reportData.push(rowData);
		}

		// Log the report data to the console
		console.log('Borrowers Report Data:', reportData);

		// Print the report
		printReport(table);
	}

	// Function to print the report
	function printReport(table) {
		// Create a new window for printing
		var printWindow = window.open('', '_blank');

		// Write the HTML content of the table to the new window
		printWindow.document.write('<html><head><title>Print Report</title>');
		printWindow.document.write('</head><body>');
		printWindow.document.write('<h1>Report</h1>');
		printWindow.document.write('<table>');
		printWindow.document.write(table.innerHTML);
		printWindow.document.write('</table>');
		printWindow.document.write('</body></html>');

		// Close the document of the new window to start printing
		printWindow.document.close();

		// Print the new window
		printWindow.print();
	}

	// Function to hide the tables
	function hideTables() {
		document.getElementById("loans-report").style.display = "none";
		document.getElementById("payment-report").style.display = "none";
		document.getElementById("borrowers-report").style.display = "none";
	}

	// Function to show the selected report
	function showReport(reportType) {
		hideTables();

		if (reportType === "loans") {
			generateLoansReport();
		} else if (reportType === "payments") {
			generatePaymentReport();
		} else if (reportType === "borrowers") {
			generateBorrowersReport();
		}
	}
</script>