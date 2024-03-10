<!DOCTYPE html>
<html>
<head>
    <title>PHP SMS Reminder</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css" />
</head>
<body>

    <h1>Due Payments SMS Reminder</h1>
    
    <?php
    include 'db_connect.php';
    
    // Fetch borrowers whose monthly installment is due after 3 weeks of the release date
    $currentDate = date('Y-m-d');
    $threeWeeksAgo = date('Y-m-d', strtotime('-3 weeks'));
    $query = "SELECT l.*, CONCAT(b.lastname, ', ', b.firstname, ' ', b.middlename) AS name, b.contact_no
              FROM loan_list l 
              INNER JOIN borrowers b ON b.id = l.borrower_id 
              WHERE l.date_released BETWEEN '$threeWeeksAgo' AND '$currentDate'";

    
    $result = $conn->query($query);
    if (!$result) {
        die('Query Error: ' . $conn->error);
    }
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $borrowerName = $row['name'];
            $phoneNumber = $row['contact_no'];
            $refNo = $row['ref_no']; // Get the ref_no from the loan_list table

            $loan_id = $row['id']; // Define the loan ID
            
              // Fetch balance and total balance for the current loan
              $balance = $conn->query("SELECT balance FROM payments WHERE loan_id = $loan_id")->fetch_assoc()['balance'];
              $total_balance = $conn->query("SELECT total_balance FROM loan_list WHERE id = $loan_id")->fetch_assoc()['total_balance'];
    
            // Compose the SMS message
            $message = "Dear $borrowerName, this is a reminder that your monthly installment for Loan (Ref No: $refNo) is due within one week.Monthly Payable Amount balance: KSH $balance.00,total loan remaining balance: KSH $total_balance.00 Please make the payment on time. Thank you.";
    
            // Output the form for sending the SMS
            ?>
            <div class="container-fluid">
                <div class="col-lg-12">
                    <form method="post" action="send.php" id="send">
                        <input type="hidden" name="number" value="<?php echo $phoneNumber; ?>" />
                        <label for="number">Number (<?php echo $phoneNumber; ?>)</label>
                        <textarea name="message" id="message"><?php echo $message; ?></textarea>
                        <fieldset>
                            <legend>Provider</legend>
                            <label>
                                <input type="radio" name="provider" value="infobip" checked /> Infobip
                            </label>
                            <br />
                        </fieldset>
                        <button>Send</button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        echo "No borrowers found with upcoming due payments.";
    }
    ?>
    
</body>
</html>