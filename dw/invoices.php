<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	 
	$username = "dwbi1";                  // Use your username
	$password = "dwbi1";             // and your password
	$database = "localhost/o12c";   // and the connect string to connect to your database
	
	$c = oci_connect($username, $password, $database);
	if (!$c) {
		$m = oci_error();
		trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
		$query = "INSERT INTO INVOICE_VIZUALIZATION (INVOICE_DATE, TRANSPORT_VALUE, INVOICE_VALUE, ID_CLIENT, REMARKS, INVOICE_FILE) VALUES ('" . $_POST["INVOICE_DATE"] . "','" . $_POST["TRANSPORT_VALUE"] . "','" . $_POST["INVOICE_VALUE"] . "','" . $_POST["ID_CLIENT"] . "','" . $_POST["REMARKS"] . "','" . $_POST["INVOICE_FILE"] . "')";
		
		$s = oci_parse($c, $query);
		if (!$s) {
			$m = oci_error($c);
			trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
		}
		
		$r = oci_execute($s);
		if (!$r) {
			$m = oci_error($s);
			trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
		}
		oci_free_statement($s);
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>DW</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css" />
		
		<!--Data Tables-->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css"> 

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="index.php" class="nav-link js-scroll-trigger">Clients</a></li>
                    <li class="nav-item"><a href="orders.php" class="nav-link js-scroll-trigger">Orders</a></li>
                    <li class="nav-item"><a href="invoices.php" class="nav-link js-scroll-trigger">Invoices</a></li>
                </ul>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container-fluid p-0">
            <!-- About-->
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-5">
                        Invoices (OLTP)
                    </h1>
                    <div class="mb-5">
						<?php
							
							$query = "SELECT a.ID_INVOICE, a.ID_CLIENT, b.FIRST_NAME, b.LAST_NAME, b.PHONE, b.EMAIL, b.ADDRESS, b.POSTAL_CODE, a.INVOICE_DATE, a.REMARKS, a.TRANSPORT_VALUE, a.INVOICE_VALUE, a.INVOICE_FILE FROM INVOICE a INNER JOIN CLIENT b ON a.ID_CLIENT = b.ID_CLIENT";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							
							echo "<table id='table'>\n";
							$ncols = oci_num_fields($s);
							echo "<thead><tr>\n";
							for ($i = 1; $i <= $ncols; ++$i) {
								$colname = oci_field_name($s, $i);
								echo "  <th>".htmlspecialchars($colname,ENT_QUOTES|ENT_SUBSTITUTE)."</th>\n";
							}
							echo "</tr></thead>\n";
							 
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<tr>\n";
								foreach ($row as $item) {
									echo "<td>";
									echo $item!==null?htmlspecialchars($item, ENT_QUOTES|ENT_SUBSTITUTE):"&nbsp;";
									echo "</td>\n";
								}
								echo "</tr>\n";
							}
							echo "</table>\n";
							oci_free_statement($s);
						?>
                    </div>
                </div>
            </section>
			
            <section class="resume-section" id="about">
                <div class="resume-section-content">
                    <h1 class="mb-5">
                        Invoices
                    </h1>
                    <div class="mb-5">
						<?php
							
							$query = "SELECT * FROM INVOICE_VIZUALIZATION";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							
							echo "<table id='table2'>\n";
							$ncols = oci_num_fields($s);
							echo "<thead><tr>\n";
							for ($i = 1; $i <= $ncols; ++$i) {
								$colname = oci_field_name($s, $i);
								echo "  <th>".htmlspecialchars($colname,ENT_QUOTES|ENT_SUBSTITUTE)."</th>\n";
							}
							echo "</tr></thead>\n";
							 
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<tr>\n";
								foreach ($row as $item) {
									echo "<td>";
									echo $item!==null?htmlspecialchars($item, ENT_QUOTES|ENT_SUBSTITUTE):"&nbsp;";
									echo "</td>\n";
								}
								echo "</tr>\n";
							}
							echo "</table>\n";
							oci_free_statement($s);
						?>
                    </div>
                </div>
            </section>
			
			<section class="resume-section">	
                <div class="resume-section-content">
                    <h1 class="mb-5">
                        Add Invoice
                    </h1>
					
					<form action="index.php" method="POST">
						<div class="mb-2">
							<input type="date" name="INVOICE_DATE" placeholder="Invoice Date" required />
						</div>
						<div class="mb-2">
							<input type="number" name="TRANSPORT_VALUE" placeholder="Transport Value" required />
						</div>
						<div class="mb-2">
							<input type="number" name="INVOICE_VALUE" placeholder="Invoice Value" required />
						</div>

						<div class="mb-2">
							
						<?php							 
							$query = "select ID_CLIENT, FIRST_NAME, LAST_NAME from dwbi1.CLIENT";
							$s = oci_parse($c, $query);
							if (!$s) {
								$m = oci_error($c);
								trigger_error('Could not parse statement: '. $m['message'], E_USER_ERROR);
							}
							
							$r = oci_execute($s);
							if (!$r) {
								$m = oci_error($s);
								trigger_error('Could not execute statement: '. $m['message'], E_USER_ERROR);
							}
							echo "<select name='ID_CLIENT' required><option disabled>Select a client</option>\n";
							while (($row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
								echo "<option value ='" . $row["ID_CLIENT"] . "'>" . $row["ID_CLIENT"] . " - " . $row["FIRST_NAME"] . " " . $row["LAST_NAME"] . "</option>";
							}
							echo "</select>";
							
							oci_free_statement($s);
						?>
						</div>
						
						<div class="mb-2">
							<input type="text" name="REMARKS" placeholder="Remarks" required />
						</div>
						<div class="mb-2">
							<input type="file" name="INVOICE_FILE" placeholder="Invoice File" required />
						</div>
						
						<div class="mb-5">
							<button type="submit">Add</button>
						</div>
						
					</form>
				</div>
				
            </section>
			
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
     
	 <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
       
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>		

	   <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
		
		<script type="text/javascript">
			$(document).ready( function () {
				$('#table').DataTable({
					"columns": [
						{ "data": "ID_INVOICE" },
						{ "data": "ID_CLIENT" },
						{ "data": "FIRST_NAME" },
						{ "data": "LAST_NAME" },
						{ "data": "PHONE" },
						{ "data": "EMAIL" },
						{ "data": "ADDRESS" },
						{ "data": "POSTAL_CODE" },
						{ "data": "INVOICE_DATE" },
						{ "data": "REMARKS" },
						{ "data": "TRANSPORT_VALUE" },
						{ "data": "INVOICE_VALUE" },
						{ "data": "INVOICE_FILE" }
					]
				});
				
				$('#table2').DataTable({
					"columns": [
						{ "data": "ID_INVOICE" },
						{ "data": "INVOICE_DATE" },
						{ "data": "TRANSPORT_VALUE" },
						{ "data": "INVOICE_VALUE" },
						{ "data": "ID_CLIENT" },
						{ "data": "REMARKS" },
						{ "data": "INVOICE_FILE" }
					]
				});
			});
		</script>
    </body>
</html>
<?php 
	oci_close($c);
?>
