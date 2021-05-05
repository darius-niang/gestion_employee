<?php
	include("../inc/header.php");

    include('../phpclasses/pagination.php');

    $limit = 10;
	    
	//get number of rows
	$queryNum = $db_connect->query("SELECT COUNT(*) as postNum FROM sharp_emp WHERE status = 'former'");
	$resultNum = $queryNum->fetch_assoc();
	$rowCount = $resultNum['postNum'];
										    
	//initialize pagination class
	$pagConfig = array(
		'totalRows' => $rowCount,
		'perPage' => $limit,
		'link_func' => 'pastsearchFilter'
	);
	$pagination =  new Pagination($pagConfig);
										    
	//get rows

?>
	<section class="side-menu fixed left">
		<div class="top-sec">
			<div class="dash_logo">
			</div>			
			<p>Système d'enregistrement des employés</p>
			</div>
		<ul class="nav">
			<li class="nav-item"><a href="../dashboard"><span class="nav-icon"><i class="fa fa-users"></i></span>Tous les anciens Employés</a></li>
			<li class="nav-item"><a href="../dashboard/current_employees.php"><span class="nav-icon"><i class="fa fa-check"></i></span>Employés Actuels</a></li>
			<li class="nav-item current"><a href="../dashboard/past_employees.php"><span class="nav-icon"><i class="fa fa-times"></i></span>Anciens employés</a></li>
			<?php if($usertype == "Admin"){ ?>
				<li class="nav-item"><a href="../dashboard/add_employee.php"><span class="nav-icon"><i class="fa fa-user-plus"></i></span>Ajouter un employé</a></li>
				<li class="nav-item"><a href="../dashboard/add_user.php"><span class="nav-icon"><i class="fa fa-user"></i></span>Ajouter un utilisateur</a></li>
			<?php		} ?>
			<li class="nav-item"><a href="../dashboard/settings.php"><span class="nav-icon"><i class="fa fa-cog"></i></span>Réglages</a></li>
			<li class="nav-item"><a href="../dashboard/logout.php"><span class="nav-icon"><i class="fa fa-sign-out"></i></span>Déconnexion</a></li>
		</ul>
	</section>
	<section class="contentSection right clearfix">
		<div class="container">
			<div class="wrapper employee_list clearfix">
				<div class="section_title">Les Anciens employés</div>
				<div class="top-bar">
					<div class="top-item">
						<form id="empFilter" method="post" action="">
							<input class="filterField filterVal" type="text" placeholder="Search Name" onkeyup="pastsearchFilter()">
						</form>
					</div>
					<div class="top-item">
						<form id="empFilter" method="post" action="">
							<select class="sortField sortVal" onchange="pastsearchFilter()">
								<option value="ASC">Récent</option>
								<option value="DESC">Anciens</option>
							</select>
						</form>
					</div>
				</div>
				<?php
					$getemp = mysqli_query($db_connect, "SELECT * FROM sharp_emp WHERE status = 'former' ORDER BY id ASC");
					$getempcount = mysqli_num_rows($getemp);
				?>
				<ul class="emp_list">
					<li class="emp_list_head">
						<div class="emp_item_head emp_id">ID Employé</div>
						<div class="emp_item_head emp_name">Nom</div>
						<div class="emp_item_head">Date d'emploie</div>
						<div class="emp_item_head">Type d'emploi</div>
						<div class="emp_item_head emp_status">Statut</div>
						<div class="emp_item_head">Action</div>
					</li>
					<div id="displayempList">
						<?php
							if($getempcount >= 1 ){
								while($fetch = mysqli_fetch_assoc($getemp)){
									$id = $fetch['id'];
									$emp_id = $fetch['employee_id'];
									$first_name = $fetch['first_name'];
									$middle_name = $fetch['middle_name'];
									$last_name = $fetch['last_name'];
									$date_employed = $fetch['date_employed'];
									$job_type = $fetch['job_type'];
									$status = $fetch['status'];

									$date_employed = date("jS F Y", strtotime($date_employed));

									if($middle_name == ""){
										if($usertype == "Admin"){
											echo '										
												<li class="emp_item">
													<div class="emp_column emp_id">'.$emp_id.'</div>
													<div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
													<div class="emp_column">'.$date_employed.'</div>
													<div class="emp_column">'.$job_type.'</div>
													<div class="emp_column emp_status">'.$status.'</div>
													<div class="emp_column">
														<ul class="action_list">
															<li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
															<li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
															<li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
														</ul>
													</div>
												</li>
											';
										} else {
											echo '										
												<li class="emp_item">
													<div class="emp_column emp_id">'.$emp_id.'</div>
													<div class="emp_column emp_name">'.$first_name." ".$last_name.'</div>
													<div class="emp_column">'.$date_employed.'</div>
													<div class="emp_column">'.$job_type.'</div>
													<div class="emp_column emp_status">'.$status.'</div>
													<div class="emp_column">
														<ul class="action_list">
															<li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
														</ul>
													</div>
												</li>
											';											
										}
									} else {
										if($usertype == "Admin"){
											echo '										
												<li class="emp_item">
													<div class="emp_column emp_id">'.$emp_id.'</div>
													<div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
													<div class="emp_column">'.$date_employed.'</div>
													<div class="emp_column">'.$job_type.'</div>
													<div class="emp_column emp_status">'.$status.'</div>
													<div class="emp_column">
														<ul class="action_list">
															<li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
															<li class="action_item action_edit" data-id="'.$id.'" title="Edit"><i class="fa fa-pencil-square-o"></i></li>
															<li class="action_item action_delete" data-id="'.$id.'" title="Delete"><i class="fa fa-trash-o"></i></li>
														</ul>
													</div>
												</li>
											';
										} else {

											echo '										
												<li class="emp_item">
													<div class="emp_column emp_id">'.$emp_id.'</div>
													<div class="emp_column emp_name">'.$first_name." ".$middle_name." ".$last_name.'</div>
													<div class="emp_column">'.$date_employed.'</div>
													<div class="emp_column">'.$job_type.'</div>
													<div class="emp_column emp_status">'.$status.'</div>
													<div class="emp_column">
														<ul class="action_list">
															<li class="action_item action_view" data-id="'.$id.'" title="View"><i class="fa fa-eye"></i></li>
														</ul>
													</div>
												</li>
											';
										}
									}
								}
								echo $pagination->createLinks();
							} else {
								echo '<li class="emp_item"> No employee record found </li>';
							}
						?>
					</div>
				</ul>
			</div>
		</div>
		<div class="modal">
			<span class="close-modal">
				<img src="../images/times.png">
			</span>
			<div class="inner_section">
				<div id="record_container" class="record_container">
					<span class="print-modal" onclick="Clickheretoprint()">
						<img src="../images/print.png">
					</span>
					<div id="table">
					</div>
					<div class="printbtn_wrapper">
						<span class="printbtn">Impression</span>
					</div>
				</div>
			</div>
		</div>
		<div class="del_modal">
			<div class="inner_section">
				<div class="delcontainer">
					<div class="del_title">Supprimer l'enregistrement</div>
					<div class="del_warning"></div>
					<div class="btnwrapper">
						<span class="delbtn yesbtn" data-id="">Oui</span>
						<span class="delbtn nobtn">Non</span>
					</div>
				</div>
			</div>
		</div>
	</section>
<script type="text/javascript" src="../js/global.js"></script>
</body>
</html>