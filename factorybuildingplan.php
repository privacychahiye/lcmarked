<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Factory Building Plan Applications (<?php echo $title;?>)
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url();?>department/home/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active"> Factory Building Plan Applications (<?php echo $title;?>) </li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header">
					</div>
					<div class="box-body pad table-responsive">
						<p>List of Applications based on current status</p>
						<table class="table table-bordered text-center">
							<tbody>
								<tr> 
								   <?php if($showverification_senttab == "true"){ ?>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=sentverification" class="btn btn-block btn-primary">Applications sent for Verification(<?php echo count($totalsentverification); ?>)</a></td>
								   <?php } ?>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=hepc" class="btn btn-block btn-primary">HEPC(<?php echo $hepc_total; ?>)</a></td>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=new" class="btn btn-block btn-primary">New(<?php echo $new_total; ?>)</a></td>
									<?php if(in_array($_SESSION['department']['job_id'],array_column($jdlist,'job_id'))){?>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=jdpendency" class="btn btn-block btn-primary">Pending for Initiation(<?php echo $jdpendency_total; ?>)</a></td>
									<?php }?>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=assigned" class="btn btn-block btn-default">Marked(<?php echo($assigned_total != "" ? $assigned_total : 0); ?>)</a></td>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=pending_scrutiny" class="btn btn-block btn-warning">Pending Signed Scurtiny(<?php echo($pending_scrutiny != "" ? $pending_scrutiny : 0); ?>)</a></td>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=process" class="btn btn-block btn-info">Process(<?php echo $process_total; ?>)</a></td>
									<?php if(in_array(122,$adminPrivilege)){?>
										<td><a href="<?php echo base_url();?>department/factorybuilding?type=unpublic" class="btn btn-block btn-success ">Unpublished Licence(<?php echo $unpublic_total; ?>)</a></td>
									<?php }?>
									<?php if(in_array(121,$adminPrivilege)){?>
										<td><a href="<?php echo base_url();?>department/factorybuilding?type=unpub_objection" class="btn btn-block btn-danger ">Unpublished Observation (<?php echo $objection_total_unpub; ?>)</a></td>
									<?php }?>
									<?php if(in_array(146,$adminPrivilege)){?>
										<td><a href="<?php echo base_url();?>department/factorybuilding?type=unpubrej" class="btn btn-block btn-danger ">Unpublished Rejection(<?php echo $unpubrej_total; ?>)</a></td>
									<?php }?>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=objection" class="btn btn-block btn-danger ">Observation (<?php echo $objection_total; ?>)</a></td>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=reply" class="btn btn-block btn-danger ">Reply(<?php echo $reply_total; ?>)</a></td>	
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=stability" class="btn btn-block btn-danger ">Stability Certificate(<?php echo $stability; ?>)</a></td>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=twentyfive" class="btn btn-block btn-danger ">Pendency more than 25 days  (<?php echo $twentyfive; ?>)</a></td>
									<td><a href="<?php echo base_url();?>department/factorybuilding?type=thirtytwo" class="btn btn-block btn-danger ">Pendency more than 32 days (<?php echo $thirtytwo; ?>)</a></td>								
										<!-- <td><a href="<?php echo base_url();?>department/factorybuilding?type=newtab" class="btn btn-block btn-danger ">Pendency by days (<?php echo $newtab; ?>)</a></td>									 -->
									<td><a href="<?php  echo base_url();?>department/factorybuilding?type=unassigned" class="btn btn-block btn-danger">Unassigned (<?php echo $total_unassigned; ?>)</a></td>
								</tr>
							</tbody></table>
					</div><!-- /.box -->
				</div>
				<?php if ($_SESSION['department']['job_id'] == 157 && $case == 'assigned') { ?>
					<div class="box">
						<table class="table  text-center" style=" width: auto;">
							<div class="box-header with-border">
								<h3 class="box-title">Marked Applications</h3>
							</div>
							<tbody>
								<tr>
									<td>
										<a href="<?php echo base_url('department/factorybuilding?type=assigned'); ?>" 
										class="btn btn-block <?php echo (empty($lc_filter)) ? 'btn-primary' : 'btn-default'; ?>"
										style="height: 100%;">
											All
										</a>
									</td>

									<?php foreach ($lc_purposes as $purpose) { ?>
										<td >
											<a href="<?php echo base_url('department/factorybuilding?type=assigned&lc_filter=' . $purpose['id']); ?>" 
											class="btn btn-block <?php echo ($lc_filter == $purpose['id']) ? 'btn-primary' : 'btn-default'; ?>">
												
												<span><?php echo htmlspecialchars($purpose['action_name']); ?>(<?php echo isset($purpose['app_count']) ? $purpose['app_count'] : 0; ?>)</span>
												
												
													
												
											</a>
										</td>
									<?php } ?>
								</tr>
							</tbody>
						</table>
					</div>
				<?php } ?>
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Building Plan Applications</h3>
					</div>
					
					<div class="box-body">
						<?php if(!empty($this->session->userdata('msg'))) { ?>
							<div class="alert alert-warning alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
								<?php echo $this->session->userdata('msg'); ?>
							</div>
						<?php } ?>                    
						<?php if(!empty(validation_errors())) { ?>  
							<div class="alert alert-danger alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
								<?php echo validation_errors(); ?>
							</div>
						<?php } ?>  
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>BIP</th>  
									<th>Plan ID</th>
									<th>Factory Name</th>
									<th>Type</th>
									<th>Status</th>
									<?php if($case == 'thirtyfive' ||  $case == 'twenty'){ ?>
										<th>Total Objection(s)</th>		
										<th>Pending since(days)</th>		
									<?php } ?>
									<th>Submitted On</th> 
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$this->load->model('department/factorybuilding_model');
									
									if(!empty($complaints)) { 
										//print"<pre>";print_r($complaints);die;
										foreach($complaints as $complaint) {
											$factory_info = $this->factorybuilding_model->getFactoryDetail($complaint['factory_reg_id']);
											$complaint_type_format = ($complaint['type_of_construction'] == 1)?'Existing':'Proposed';
											
											if($complaint['final_status'] == 0){
												$status_name = 'Pending';
												}else if($complaint['final_status'] == 1){
												$status_name = 'Submitted';
												}else if($complaint['final_status'] == 2){
												$status_name = 'Approved';
												}else if($complaint['final_status'] == 3){
												$status_name = 'Processing';
												}else if($complaint['final_status'] == 4){
												$status_name = 'Objected';
												}else if($complaint['final_status'] == 5){
												$status_name = 'Aborted';
												}else if($complaint['final_status'] == 6){
												$status_name = 'Processed';
												}else if($complaint['final_status'] == 7){
												$status_name = 'Unpublished Objection';
												}else if($complaint['final_status'] == 8){
												$status_name = 'Unpublished License';
												}else if($complaint['final_status'] == 11){
												$status_name = 'Unpublished Rejection';
												}else if($complaint['final_status'] == 12){
												$status_name = 'Pending Signed Scrutiny';
												}
											if($title == 'Processed'){
												$idd= $complaint['complaint_id'];
												}else{
												$idd= $complaint['id'];
											}
											
											$now 			= time();
											$lic_date 		= strtotime($complaint['modified_date']);
											$date_diffrence = $now - $lic_date;
											$pending_since	=	round($date_diffrence/(60 * 60 * 24));
											
											$count++;
											$countpage++;
											echo '<tr>';
											echo '<td>'.$countpage.'</td>';
											echo '<td>'.$complaint['factory_reg_id'].'</td>';
											echo '<td>'.$complaint['plant'].'</td>';
											echo '<td>M/s '.$factory_info['factory_reg_u_name'].'</td>';
											echo '<td>'.$complaint_type_format.'</td>';
											echo '<td>'.$status_name.'</td>';
											if($case == 'thirtyfive' ||  $case == 'twenty'){ 
												echo '<td>'.getObjectionsBylicFBP($idd).'</td>';
												echo '<td>'.$pending_since.'</td>';
											}
											echo '<td>'.date("d-m-Y",strtotime($complaint['modified_date'])).'</td>';
											if($this->input->get('type') == 'hepc'){
											echo '<td><a class="btn btn-primary"  href="'.base_url('department/factorybuilding/updateCircle').'/'.$complaint['factory_reg_id'].'">Update</a> ';
											' </td>';		
											}else{
											echo '<td><a class="btn btn-primary"  href="'.base_url('department/factorybuilding/viewdetail').'/'.$idd.'">View Detail</a> ';
											' </td>';	
											}
											echo '</tr>';
										}
										} else {
										echo '<tr><td colspan="7" align="center">No Result Found</td></tr>';
									}
								?>
							</tbody>                        
						</table>
					</div>
					<div class="box-footer clearfix">
						<ul class="pagination pagination-sm no-margin pull-right">
							<?php echo $pagination; ?>
						</ul>  
					</div>
				</div>
			</div>
		</div>
	</section>
</div>  <!-- /.content-wrapper -->
