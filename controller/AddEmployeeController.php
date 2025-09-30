<?php include("../model/EmployeeModel.php")?>
<?php

	if (isset($_POST['btnSubmit']))
	{
		$empCodeName = $_POST["empCodeNum"];
		$empFirstName = $_POST["empFirstName"];
		$empLastName = $_POST["empLastName"];
		$empDoB = $_POST["empDoB"];
		$empBloodGroup = $_POST["empBloodGroup"];
		$empGender = $_POST["empGender"];
		$empPhoneNumPersonal = $_POST["empPhoneNumPersonal"];
		$empPhoneNumOffice = $_POST["empPhoneNumOffice"];
		$empParmanentAddress = $_POST["empParmanentAddress"];
		$empPresentAddress = $_POST["empPresentAddress"];
		$empDptId = $_POST["cat"];
		$empDesiId = $_POST["subcat"];
		$empEmailAddress = $_POST["empEmailAddress"];
		$empLoginPass = $_POST["empLoginPass"];
		$userCodeWhoCreateEmp = $_SESSION['officeUserName'];
		$empVerification = 0;
		$empType = 3;
		
		$objEmployee = new Employee();
		//object declaretion for using Employee class. Employee class is in EmployeeModel.php file
		$objEmployee->dbCreateEmpQuery($empCodeName,$empFirstName,$empLastName,$empDoB,$empBloodGroup,$empGender,$empPhoneNumPersonal,$empPhoneNumOffice,$empParmanentAddress,$empPresentAddress,$empDptId,$empDesiId,$empEmailAddress,$empLoginPass,$userCodeWhoCreateEmp,$empVerification,$empType);
		if($objEmployee->CreatedOrNot)
		{
			$_SESSION['msgForEmpCreate'] = 1;
			//echo $objEmployee->CreatedOrNot;
			header("Location:../view/AddEmployee.php");
		}
		else
		{
			$_SESSION['msgForEmpCreate'] = 0;
			//echo $objEmployee->CreatedOrNot;
			header("Location:../view/AddEmployee.php");
		}
	}
	
	if (isset($_POST['btnVerify']))
	{
		$empWhoVerifytheEmployee = $_SESSION['officeUserName'];
		$empUserId = $_POST['btnVerify'];
		
		$objEmployee = new Employee();
		$verificationStatus = $objEmployee->dbEmpStatus($empUserId);

	if ($verificationStatus instanceof mysqli_result) {
		while ($row = mysqli_fetch_array($verificationStatus)) {
			if ($row['eEmployeeVerification'] == 1) {
				$empVerification = 0;
			} else {
				$empVerification = 1;
			}
		}
	} else {
		// Handle query error
		error_log('Query failed or returned no result in dbEmpStatus');
	}
		
		//echo "<br/>Who Varify : ".$empWhoVerifytheEmployee."<br/> VarifyData : ".$empVerification."<br/> User : ".$empUserId;
		
		$objEmployeeForVerify = new Employee();
		$objEmployeeForVerify->dbVerifyEmployee($empWhoVerifytheEmployee,$empUserId,$empVerification);
		
		if($objEmployeeForVerify->CreatedOrNot)
		{
			header("Location:../view/ListEmployee.php");
		}
		else
		{
			header("Location:../view/ListEmployee.php");
		}
	}
	
	if (isset($_POST['btnCoordinator']))
	{
		$empWhoVerifytheEmployee = $_SESSION['officeUserName'];
		$empUserId = $_POST['btnCoordinator'];
		
		$objEmployee = new Employee();
		$empType = $objEmployee->dbEmpCoordinetorType($empUserId);

	$newEmpType = null;
	if ($empType instanceof mysqli_result) {
		while ($row = mysqli_fetch_array($empType)) {
			if ($row['eEmpType'] == 3) {
				$newEmpType = 2;
			} else {
				$newEmpType = 3;
			}
			}
	} else {
		// Handle query error
		error_log('Query failed or returned no result in dbEmpCoordinetorType');
		}

	//echo "<br/>Who Varify : ".$empWhoVerifytheEmployee."<br/> VarifyData : ".$empType."<br/> User : ".$empUserId;

	$objEmployeeForVerify = new Employee();
	$objEmployeeForVerify->dbEmpTypeUpdate($empWhoVerifytheEmployee, $empUserId, $newEmpType);
		
		if($objEmployeeForVerify->CreatedOrNot)
		{
			header("Location:../view/ListEmployee.php");
		}
		else
		{
			header("Location:../view/ListEmployee.php");
		}
	}
?>