<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/innerstyle.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/developer.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/department.css"/>
<div class="content-wrapper" style="min-height: 946px;">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			View Application Details (BIP : <a href="<?php echo base_url();?>department/factory/viewAppDetails/<?php echo $factory_info['factory_reg_id'];?>" target="_blank" ><?php echo $factory_info['factory_reg_id'];?></a>)
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url();?>department/home/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="<?php echo  base_url ();?>department/factorybuilding?type=new">Building Plan Applications </a></li>
			<li class="active">View Application Details</li>
		</ol>
	</section>
	
	<!-- Main content -->
	<section class="content">
		<div class="box">
			<div class="box-body">
				<?php if (!empty($this->session->userdata('msg'))) { ?>
					<div class="alert alert-warning alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
						<?php echo $this->session->userdata('msg'); ?>
					</div>
				<?php } ?>                    
				<?php if (!empty(validation_errors())) { ?>  
					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
						<?php echo validation_errors(); ?>
					</div>
				<?php } ?>
				<div class="history">
					<h2>Applications for Factory Building Plan submitted previously</h2>
					<div class="history-detail">
						<?php 
							$latestappln 	=	$this->building_model->getPlans($buildingPlan['factory_reg_id']);
							$latestplanid 	=	$latestappln[0]['id'];
							
							if(count($factory_list) > 0){
								$i=0;
								foreach ($factory_list as $plans){
									
									if ($i % 2 == 0){
										$class= 'info-form gray';
										}else{
										$class= 'info-form';
									}?>
									<div class="<?php echo $class;?>">
										<ul>
											<li><a href="javascript:void(0)" style="border-right: 1px solid #000;">App ID : <strong><?php echo $plans['id']?></strong></a></li>
											<li><a href="javascript:void(0)" style="border-right: 1px solid #000;">PlanID : <strong><?php echo $plans['plant']?></strong></a></li>
											<li><a href="javascript:void(0)">Submitted on : <strong><?php echo date("d-m-y",strtotime($plans['modified_date']))?></strong> </a></li>
											<li><a href="javascript:void(0)">Status : <strong>
												
												<?php if($plans['final_status'] ==0){?>
													Pending
													<?php }else if($plans['final_status'] ==1){?>
													Submitted
													<?php }else if($plans['final_status'] ==2){?>
													Accepted	
													<?php }else if($plans['final_status'] ==3){?>
													Processing
													<?php }else if($plans['final_status'] ==4){?>
													Objected
													<?php }else if($plans['final_status'] ==5){?>
													Aborted
													<?php }else if($plans['final_status'] ==8){?>
													Unpublished License
													<?php }else if($plans['final_status'] ==11){?>
													Unpublished Rejection
													<?php }else if($plans['final_status'] ==10){?>
													Rejected
													<?php }else{?>
													Processing
												<?php }?></strong></a></li>
												<?php if($plans['final_status'] ==0){?>
													<li><a href="javascript:void(0)" class="red">(OTP Not Submitted by Management)</a></li>
													<?php }else{?>
													<li><a href="<?php echo base_url();?>department/factorybuilding/viewdetail/<?php echo $plans['id']?>">View Application Details </a></li>
												<?php }?>
												
												<?php if($plans['final_status'] ==2) { 
													if(!empty($cert_pdf->cert_pdf_path)){ ?>
													<li><a target="_blank"  href="<?php echo  STORAGE_URL.$cert_pdf->cert_pdf_path;?>">View Certificate</a></li>
													<?php } else { ?>
													<li><a target=	"_blank"  href="<?php echo base_url();?>department/factorybuilding/view_certificate/<?php echo $plans['id']?>">View Certificate</a></li>
												<?php 	} ?>
												<?php }?> 
										</ul>
									</div>
									<?php $i++;
									}}?>
					</div><!--history-detail close here-->	
				</div><!--history close here-->
			</div>
		</div>
		<?php if($buildingPlan['final_status'] ==8 && $showLink == 'true'){?>
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">				
						<div class="box-header">
							<div  style="text-align:right;font-weight:bold;font-size:15px;margin-right:10px">
								<span style="padding-right:20px"><a href="<?php echo base_url();?>department/factorybuilding/previewCertificate/<?php echo $complaint_id?>" target="_blank">Preview/Publish Certificate</a></span>							
							</div>
						</div><!-- /.box-header -->								
					</div>
				</div>
			</div>
		<?php }?>
		
		<?php if($buildingPlan['final_status'] == 1 || $buildingPlan['final_status'] == 3 || $buildingPlan['final_status'] == 4 || $buildingPlan['final_status'] == 6 || $buildingPlan['final_status'] == 7 || $buildingPlan['final_status'] == 11){?>
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">				
						<div class="box-header">
							<div style="text-align:right;font-weight:bold;font-size:15px;margin-right:10px">
								<span style="padding-right:20px"><a href="<?php echo base_url();?>department/factorybuilding/generateObjLetter/<?php echo $complaint_id?>/" target="_blank"><strong>Generate/Edit Observation letter&nbsp;</strong></a></span>
							</div>
							<div style="text-align:right;font-weight:bold;font-size:15px;margin-right:10px">
								<span style="padding-right:20px"><a href="<?php echo base_url();?>department/factorybuilding/generateRejLetter/<?php echo $complaint_id?>/" target="_blank"><strong>Generate/Edit Rejection letter&nbsp;</strong></a></span>
							</div>							
						</div><!-- /.box-header -->								
					</div>
				</div>
			</div>			
		<?php }?>
		<?php if(!empty($scr_pdf)) { ?>
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">				
						<div class="box-header">
							<div style="text-align:right;font-weight:bold;font-size:15px;margin-right:10px">
								<span style="padding-right:20px"><a href="http://61.0.172.47/<?php echo $scr_pdf->scrutiny_pdf_path ?>" target="_blank"><strong>View Signed Scrutiny&nbsp;</strong></a></span>
							</div>
							
						</div><!-- /.box-header -->								
					</div>
				</div>
			</div>			
		<?php }?>
		
		<div class="row">
			<div class="col-md-12">
				<?php if($buildingPlan['final_status'] ==2 && $plan_cert['cert_status'] == 1) { ?>
					<div class="box box-info">				
						<div class="box-header">
							<table>
								<tr>
									<td><strong>License Published By</strong></td>
									<td><?php echo $plan_cert['publishedby_name']; ?></td>
								</tr>
								<tr>
									<td><strong>License Published Date</strong></td>
									<td><?php echo date("d-m-Y", strtotime($plan_cert['date_published'])); ?></td>
								</tr>
							</table>
							
						</div>
					</div><!--main-top close Here -->
				<?php }?>
			</div>
		</div>
		
		<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>department/factorybuilding/viewdetail/<?php echo $complaint_id;?>" id="frm">
			<?php if($buildingPlan['final_status'] == 2 && $buildingPlan['cert_upload_status'] == 0){ ?>
				<div class="row">
					<!-- left column -->
					<div class="col-md-12">
						<!-- Horizontal Form -->
						<div class="box box-info">				
							<div class="box-header">
								
								<div class="form-group">
									<label for="exampleInputFile">Upload Signed Certificate</label>
									<input type="file" name = "doc_file" attr="filename">
									<input type="hidden" name = "doc_filename_image" id="filename" value="<?php echo set_value('doc_filename_image');?>">
									<?php echo form_error('doc_filename_image', '<div class="error">', '</div>'); ?>
									<input type="hidden" name="factory_reg_id" value="<?php echo $factory_id;?>" />
									<input type="hidden" value="<?php echo $complaint_id;?>" name="complaint_id"/>
									<span class="allowed_class">(Only .jpeg .jpg .png .gif .doc .docx .pdf allowed of max size 2 MB)</span>	
								</div>
								<div class="from-group">
									<input type="submit" value="Upload Document" name="upload_certificate" class="btn btn-primary pull-left">
								</div>	
							</div><!-- /.box-header -->								
						</div>
					</div>
				</div>	
			<?php } ?>	
			
			<?php if($buildingPlan['final_status'] == 2 && $buildingPlan['cert_upload_status'] == 1){ ?>
				<div class="row">
					<!-- left column -->
					<div class="col-md-12">
						<!-- Horizontal Form -->
						<div class="box box-info">				
							<div class="box-header">
								<div class="box-header">	
									<a href="<?php echo  STORAGE_URL.$buildingPlan['building_plan_signed_cert'];?>" target="_blank" class="btn btn-box-tool pull-right " ><strong style="color:#3c8dbc" >Download Signed Certificate</strong></a>
								</div>    
							</div><!-- /.box-header -->								
						</div>
					</div>
				</div>	
			<?php } ?>			
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">				
						<div class="box-header">
							<?php if($buildingPlan['stability_application'] == 1){?>							
								<p><strong>Type of Application : Approval for Stability Certificate</strong></p>
							<?php }?>
						</div><!-- /.box-header -->
						<!-- form start -->										
						<div class="box-body">
							<div class="new-listing">
								<div class="new-listing-forms" style="margin:0"><div style="float:left"><b>Plan Id - <?php echo $buildingPlan['plant'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;</div>
									<ul>
										<li><a href="<?php echo base_url();?>department/factorybuilding/viewdetail/<?php echo $complaint_id?>" style="background: #cb221b;color: #ffffff;border:1px solid #cb221b;" class="save_comnt">Form-1</a></li>
										<li><a href="<?php echo base_url();?>department/factorybuilding/form1a/<?php echo $complaint_id?>" class="save_comnt">Form-1-A</a></li>
										<li><a href="<?php echo base_url();?>department/factorybuilding/form1ques/<?php echo $complaint_id?>" class="save_comnt">Form-1-A Questionnarie</a></li>
										<?php if($buildingPlan['type_of_construction'] == 1){?>
											<li><a href="<?php echo base_url();?>department/factorybuilding/form1b/<?php echo $complaint_id?>" class="save_comnt">Form-1-B</a></li>
										<?php }?>
										<li><a href="<?php echo base_url();?>department/factorybuilding/blueprint/<?php echo $complaint_id?>" class="save_comnt">Blueprint Details</a><?php /*if($buildingPlan['checkblueprint'] == 2){?><img src="<?php echo base_url('assets/images/tick.png');?>" alt="Approved"  title="Approved"><?php }else if($buildingPlan['checkblueprint'] == 1){?><img src="<?php echo base_url('assets/images/pending.png');?>" alt="Approval Pending"  title="Approval Pending"><?php }else{?><img src="<?php echo base_url('assets/images/axclamation.png');?>" alt="Not Submitted Yet"  title="Not Submitted Yet"><?php }*/?></li>
										<?php if(($buildingPlan['final_status'] == 0 && $latestplanid == $factory_list[0]['id']) || ($buildingPlan['final_status'] != 0 && $buildingPlan['checkChecklist'] == 1) ) { ?>
											<li><a href="<?php echo base_url();?>department/factorybuilding/checklist/<?php echo $complaint_id?>" class="save_comnt">Checklist</a></li>
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
						<?php 
						
						// if($tempChecked->temp_check == 1){
						// 	$checked="checked";
						// 	}else{
						// 	$checked="";
						// } 
						?>
						<!-- <label  for="publish_checkbox">
							<input type="checkbox" <?php echo $checked; ?> name="publish_check" id="publish_checkbox" value="1"> Do the establishment require to upload blueprint again ?
						</label>							 -->
					</div>
				</div>
			</div>
			
			<div class="box">
				<div class="box-body">
					<div class="main-top" style="text-align:center;">
						<h2>FORM NO. 1 <br /></h2>
						<h4>(Prescribed under Rule - 3)</h4>
					</div><!--main-top close Here -->	
					<table class="table prescribed">                            
						<tbody>
							<p class="lead">APPLICATION AND PERMISSION</p>
							<p>To construct's Extend, or take in to use any building as a Factory</p>
							<tr>
								<th style="width:50%"><span>&nbsp;</span>CAF Pin: </th>
								<td><?php echo $factory_info['cafpin'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span>1.</span> Applicant name: </th>
								<td><?php echo $factory_info['factory_reg_o_name'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span>&nbsp;</span> Applicant calling:</th>
								<td>Manager</td>
							</tr>
							<tr>
								<th style="width:50%"><span>&nbsp;</span> Occupier/Director/Partner:</th>
								<td><?php echo $buildingPlan['occupier'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span>&nbsp;</span> Applicant address:</th>
								<td><?php echo $factory_info['factory_reg_o_address'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span>2.</span> Full Name of the Factory:</th>
								<td>M/s <?php echo $buildingPlan['factory_name'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span> &nbsp;</span> Postal address of Factory: </th>
								<td>
									<?php 
										echo $buildingPlan['factory_address'];
										/*
											echo $factory_info['factory_reg_u_address'];
											echo $factory_info['villages_name'];
											echo $factory_info['tehsil_name'];
											echo $factory_info['distt_name'];
										*/
									?>
								</td>
							</tr>
							<tr>
								<th style="width:50%"><span>3.</span> Situation of Factory</th>
								<td></td>
							</tr>
							<tr>
								<th style="width:50%"><span> &nbsp;</span> a). District </th>
								<td><?php echo $factory_info['distt_name'];?></td>
							</tr> 
							<tr>
								<th style="width:50%"><span> &nbsp;</span> b). Tehsil </th>
								<td><?php echo $factory_info['tehsil_name'];?></td>
							</tr> 
							<tr>
								<th style="width:50%"><span> &nbsp;</span> c). Industrial State </th>
								<td><?php echo $factory_info['industrial_region'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span> &nbsp;</span> d). Town or Village </th>
								<td><?php echo $factory_info['villages_name'];?></td>
							</tr>
							<tr>
								<th style="width:50%"><span> &nbsp;</span> e). Industrial Area </th>
								<td><?php echo $factory_info['industrial_state'];?></td>
							</tr>
							<tr><th style="width:50%"><span>4.</span> Particulars of plant to be installed</th>
								<td><?php //echo set_value('plant_install')?><?php echo $buildingPlan['plant_install'];?></td>
							</tr>
							<tr><th style="width:50%"><span>5.</span> Type</th>
								<td><?php if($buildingPlan['type_of_construction'] ==1){?> Existing <?php }else{?>Proposed<?php }?></td>
							</tr>
							
							
							<?php if(($buildingPlan['final_status'] == 0 && $latestplanid != $factory_list[0]['id']) || ($buildingPlan['final_status'] != 0 && $buildingPlan['checkChecklist'] == 0)){?>
								
								<tr><th style="width:50%"><span> &nbsp;</span> Brief Description of the Manufacturing</th>
									<td><?php echo $buildingPlan['description']; ?></td>
								</tr>
								<tr><th style="width:50%"><span> &nbsp;</span> Flow Chart File</th>
									<td><?php if($buildingPlan['flow_chart_file'] != "undefined" && $buildingPlan['flow_chart_file'] != ""){?>
										<code><a href="<?php echo STORAGE_URL;?><?php echo $buildingPlan['flow_chart_file'];?>" target="_blank" title="Click here to view the file">view file</a></code>
										<?php }else{?>
										NA
									<?php }?></td>
								</tr>
								
								<tr><th style="width:50%"><span> &nbsp;</span>Local Authorities File</th>
									<td><?php if($buildingPlan['local_authorities_file'] != "undefined" && $buildingPlan['local_authorities_file'] != ""){?>
										<code><a href="<?php echo STORAGE_URL;?><?php echo $buildingPlan['local_authorities_file'];?>" target="_blank" title="Click here to view the file">view file</a></code>
										<?php }else{?>
										NA
									<?php }?></td>
								</tr>
								<tr><th style="width:50%"><span> &nbsp;</span>Pollution Control File</th>
									<td><?php if($buildingPlan['pollution_control_file'] != "undefined" && $buildingPlan['pollution_control_file'] != ""){?>
										<code><a href="<?php echo STORAGE_URL;?><?php echo $buildingPlan['pollution_control_file'];?>" target="_blank" title="Click here to view the file">view file</a></code>
										<?php }else{?>
										NA
									<?php }?></td>
								</tr>
								<tr><th style="width:50%"><span> &nbsp;</span>Fire Station File</th>
									<td><?php if($buildingPlan['fire_station_file'] != "undefined" && $buildingPlan['fire_station_file'] != ""){?>
										<code><a href="<?php echo STORAGE_URL;?><?php echo $buildingPlan['fire_station_file'];?>" target="_blank" title="Click here to view the file">view file</a></code>
										<?php }else{?>
										NA
									<?php }?></td>
								</tr>
								<tr><th style="width:50%"><span> &nbsp;</span>Emergency Action Plan / Complete Safety Report</th>
									<td><?php if($buildingPlan['building_surroundings_file'] != "undefined" && $buildingPlan['building_surroundings_file'] != ""){?>
										<code><a href="<?php echo STORAGE_URL;?><?php echo $buildingPlan['building_surroundings_file'];?>" target="_blank" title="Click here to view the file">view file</a></code>
										<?php }else{?>
										NA
									<?php }?></td>
								</tr>
								<tr><th style="width:50%"><span> &nbsp;</span>Proof for Cess Deposit</th>
									<td><?php if($buildingPlan['cess_deposit'] != "undefined" && $buildingPlan['cess_deposit'] != ""){?>
										<code><a href="<?php echo STORAGE_URL;?><?php echo $buildingPlan['cess_deposit'];?>" target="_blank" title="Click here to view the file">view file</a></code>
										<?php }else{?>
										NA
									<?php }?></td>
								</tr>
								
							<?php }?>
						</tbody>
					</table>
					<?php if($buildingPlan['undertaking'] == 1){ ?>
						&nbsp;
						<p><input type="checkbox" checked disabled> 
						<span class="titles">It is hereby declared that I have complied with all the statutory and mandatory requirements. I solely responsible for any kind of pending Govt. dues/cess/any kind of fees in future, if applicable.</span></p>
						<p>			
						<?php } ?>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
				
				<section>
					<div class="remarks">Remarks</div><!--remarks close Here -->
					<div class="comments">
						<?php 
							if(!empty($decisions)) {
								foreach($decisions as $decision) { 
									if($decision['jdstatus'] == 101){
									?>
									<div class="comment-top">
										<div class="comment-by">
											<strong>Commented By : </strong>
											<?php 											
												$jobid 	=	array(675,167,157,468,467,161,158,791,443,136,842);
												if(in_array($_SESSION['department']['job_id'],$jobid)){ ?>
												<?php  echo $decision['officer_name']; } else { ?>
											<?php  echo 'Department'; } ?>
										</div><!--comment-by close Here -->
										<div class="comment-on">
											<strong>Commented On : </strong><?php echo date("d-m-Y H:i A",strtotime($decision['created']));?>
										</div><!--comment-by close Here -->
									</div><!--comment-top close Here -->
									<div class="comment-text">
										<?php 
											if($decision['description']!=""){
												echo '<p>'.$decision['description'].'</p>';
												}else{
												echo '<p>No Comments</p>';
											}
										?>
										<span><strong>Marked To:</strong>
											<strong> <?php echo ucfirst($decision['assigned_name']); ?> </strong>
										</span>
									</div>
								<?php }?>
							<?php }?>
						<?php }?>
						<?php /*if($buildingPlan['jd_comment_status'] == 1 || $buildingPlan['jd_officer'] != 0){ ?>
							<?php if(empty($decisions) || (!empty($decisions) && $decisions['jdstatus'] != 101)){ ?>
								<?php 	
									$expirydate		=	date('Y-m-d',strtotime($buildingPlan['modified_date'].'+10 days'));
									$current		=	date('Y-m-d'); 
									if($expirydate <= $current){
									?>
									
									<div class="comment-text">
										<p style="word-break:break-all;color:#ff0000">Auto forwarded by system for processing and decision after passing 10 days timelines.</p>
									</div>
								<?php }?>
							<?php }?>
						<?php }*/?>
					</div><!--comments close Here -->
				</section>
				
				
				
				<section class="" id="scrutiny">			
					<div class="remarks">Office of Labour Commissioner</div><!--remarks close Here -->
					<div class="comments">
						<?php 
							if(!empty($decisions)) {
								foreach($decisions as $decision) { 
									if($decision['jdstatus'] != 101){
									?>
									<div class="comment-top">
										<div class="comment-by">
											<strong>Commented By : </strong>
											<?php 
												// 150
												$jobid 	=	array(675,167,157,468,467,161,158,791,443,136,842,155,459);
												if(in_array($_SESSION['department']['job_id'],$jobid)){ ?>
												<?php  echo $decision['officer_name']; } else { ?>
											<?php  echo 'Department'; } ?>
										</div><!--comment-by close Here -->
										<div class="comment-on">
											<strong>Commented On : </strong><?php echo date("d-m-Y H:i A",strtotime($decision['modified']));?>
											<span><?php //echo date("h:i a",strtotime($decision['modified']));?></span>
										</div><!--comment-by close Here -->
									</div><!--comment-top close Here -->
									<div class="comment-text">
										<?php 
											if($decision['description']!=""){
												echo '<p>'.$decision['description'].'</p>';
												}else{
												echo '<p>No Comments</p>';
											}
										?>
										<span style="float:left;"><strong>Status:</strong>
											<strong>
												<?php echo $decision['status'] ;											
												?>
											</strong>
										</span>
										<?php $jobid 	=	array(675,167,157,161,158,791,842);
											if(in_array($_SESSION['department']['job_id'],$jobid)){?>
											<span><strong>Marked To:</strong>
												<strong>
													<?php
														if($decision['assigned_name']!=""){
															echo ucfirst($decision['assigned_name']);
															}else{
															echo 'Not Marked';
															
														}
													?>
												</strong>
											</span>
										<?php }?>
										<?php if($decision['document'] != ''){?>
											<p style="clear:both"><strong>Optional Document:</strong>
												<a href="<?php echo STORAGE_URL;?><?php echo $decision['document'] ;?>" target="_blank">Download</a>
											</p>
										<?php } ?>
									</div>
								<?php }}}?>
					</div><!--comments close Here -->
					<?php if(!empty($final_verificationarr)){ ?>
						<div class="remarks" style="color: #f5eeee;background-color: red;font-size: 14px;font-weight: bold;" colspan="5">Verification</div><!--remarks close Here -->
						<?php foreach($final_verificationarr as $vobj){ ?>
							<div class="comments">
								<div class="comment-top">
									<div class="comment-by">
										<strong>Commented By : </strong>  
										<?php echo $vobj['verification_officer_name']; ?>															
									</div><!--comment-by close Here -->
									<div class="comment-on">
										<strong>Commented On : </strong><?php echo date("d-m-Y - h:i A",strtotime($vobj['created']));?>										
									</div><!--comment-by close Here -->
								</div><!--comment-top close Here -->
								<div class="comment-text">
									<p style="word-break:break-all"><?php echo $vobj['comment']; ?></p>
									<span><strong>Marked To:</strong> <?php echo $vobj['assigned_to_officername']; ?></span>
									<span style="float:left;" ><strong>Status:Verification </strong></span>
								</div>
							</div><!--comments close Here -->
							<?php $verifyreply = $this->factorybuilding_model->getreply_onverification($vobj['factory_reg_id'],$vobj['plan_id'],$vobj['id']); 
								if(!empty($verifyreply)){ ?>
								<div class="comments">
									<div class="comment-top">
										<div class="comment-by">
											<strong>Commented By : </strong>  
											<?php echo $verifyreply['verification_officer_name']; ?>															
										</div><!--comment-by close Here -->
										<div class="comment-on">
											<strong>Commented On : </strong><?php echo date("d-m-Y - h:i A",strtotime($verifyreply['created']));?>										
										</div><!--comment-by close Here -->
									</div><!--comment-top close Here -->
									<div class="comment-text">
										<p style="word-break:break-all"><?php echo $verifyreply['comment']; ?></p>
										
										<span><strong><?php if(isset($verifyreply['uploaded_document'])) { ?><a target="_blank" href="<?php echo STORAGE_URL; ?><?php  echo $verifyreply['uploaded_document']; ?>">View Document</a><?php } ?></strong></span>
										<span style="float:left;" ><strong>Status:Verification </strong></span>
									</div>
								</div><!--comments close Here -->
							<?php } } ?>
					<?php } ?>
					<?php if(!empty($allObjection)){?>
						<div class="observation-letter">
							<table>
								<tbody>
									<tr>
										<td style="width:20%"><strong>Observation Published on</strong></td>
										<?php $jobid 	=	array(675,167,157,161,158,791,842);
											if(in_array($_SESSION['department']['job_id'],$jobid)){?>
											<td style="width:20%"><strong>Published By</strong></td>
										<?php }?>
										<td style="width:20%"><strong>View Observation Letter</strong></td>
										<td style="width:40%" class="empty">
											<strong>Reply</strong>
											<table>
												<tbody>
													<tr>
														<td><strong>View</strong></td>
														<td><strong>Submitted On</strong></td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>											
									<?php foreach($allObjection as $objection){?>
										<tr>
											<td style="width:20%"><?php echo date("d M, Y - H:s A",$objection['obj_created']); ?></td>
											<?php $jobid 	=	array(675,167,157,161,158,791,842);
												if(in_array($_SESSION['department']['job_id'],$jobid)){?>
												<td style="width:20%"><?php echo $objection['publishedBy']; ?></td>
											<?php }?>
											<td style="width:20%">
												<a href="<?php echo base_url();?>department/factorybuilding/viewObjection/<?php echo $objection['plan_id']; ?>/<?php echo $objection['obj_id']; ?>" title="Click to View Objection Letter Details" style="color:#0066FF;" >View</a>
												<?php if($objection['replyCount'] > 0){?>
													No. of Reply(s) <?php echo $objection['replyCount']; ?>
												<?php }?>
											</td>
											<td style="width:40%">
												<?php if(!empty($objection['reply'])) { ?>    
													<table style="border:none" >
														<tbody>                          
															<?php foreach($objection['reply'] as $reply) { ?>
																<tr>
																	<td style="border:none" ><strong><a href="<?php echo base_url('department/factorybuilding/viewReplyObservation/'.$reply['rep_id']); ?>">View</a></strong></td>
																	<td style="border:none" ><strong><?php echo date('d-m-Y H:i A',strtotime($reply['rep_obj_date'])); ?></strong></td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												<?php } ?>	  
											</td>
										</tr>												
									<?php }?>									
								</tbody>
							</table>									
						</div><!--observation-letter close Here -->
					<?php }?>
					<?php if(!empty($allRejection)){?>
						<div class="observation-letter">
							<table>
								<tbody>
									<tr>
										<td style="width:20%"><strong>Rejection Published on</strong></td>
										<?php $jobid 	=	array(675,167,157,161,158,791,842);
											if(in_array($_SESSION['department']['job_id'],$jobid)){?>
											<td style="width:20%"><strong>Published By</strong></td>
										<?php }?>
										<td style="width:20%"><strong>View Rejection Letter</strong></td>									
									</tr>											
									<?php foreach($allRejection as $rejection){?>
										<tr>
											<td style="width:20%"><?php echo date("d M, Y - H:s A",$rejection['rej_created']); ?></td>
											<?php $jobid 	=	array(675,167,157,161,158,791,842);
												if(in_array($_SESSION['department']['job_id'],$jobid)){?>
												<td style="width:20%"><?php echo $rejection['publishby_name']; ?></td>
											<?php }?>
											<td style="width:20%">
												<a href="<?php echo base_url();?>department/factorybuilding/viewRejection/<?php echo $rejection['plan_id']; ?>/<?php echo $rejection['rej_id']; ?>" title="Click to View Rejection Letter Details" style="color:#0066FF;" >View</a>											
											</td>										
										</tr>												
									<?php }?>									
								</tbody>
							</table>									
						</div><!--observation-letter close Here -->
					<?php }?>
				</section>
				
				<div class="row">
					<div class="col-md-12">
						<!-- general form elements -->
						<?php // && $showLink == 'true'
							//if($_SESSION['department']['job_id'] == $buildingPlan['step1_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step2_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step3_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step4_officer'] || ($_SESSION['department']['job_id'] == 468 || $_SESSION['department']['job_id'] == 467)){
							//if($_SESSION['department']['job_id'] == $buildingPlan['step1_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step2_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step3_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step4_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step5_officer'] || $_SESSION['department']['job_id'] == $buildingPlan['step6_officer']){
							//	if(($buildingPlan['final_status'] == 1 || $buildingPlan['final_status'] == 3 || $buildingPlan['final_status'] == 4 || $buildingPlan['final_status'] == 6 || $buildingPlan['final_status'] == 7 || $buildingPlan['final_status'] == 8 || $buildingPlan['final_status'] == 11)){?>
								<?php //if($buildingPlan['jd_comment_status'] == 1 || $buildingPlan['jd_officer'] == 0){ ?>
									
									<div class="box box-primary">
										<div class="box-header with-border">
											<h3 class="box-title">Scrutinize</h3>
										</div><!-- /.box-header -->
										<!-- form start -->				
										
										<input type="hidden" value="<?php echo $complaint_id;?>" name="complaint_id"/>
										
										<input type="hidden" value="<?php echo getOfficerName($this->session->userdata['department']['officer_id'])." (".$this->session->userdata['department']['admin_post'].")" ?>" name="officer_name"/>
										
										<!--<input type="hidden" value="<?php echo $officer_id;?>" name="officer_id"/>-->
										<div class="box-body">
											
											
											<div class="form-group">
												<label>Comment:<span style="color:red;font-size:18px;">*</span></label>
												<textarea name="description"  id="description" rows="3" class="form-control"><?php if(isset($_SESSION["fbp_comment_$complaint_id"]) && !empty($_SESSION["fbp_comment_$complaint_id"])){ echo $_SESSION["fbp_comment_$complaint_id"]; } else { echo set_value('description'); } ?></textarea>
											</div>
											<div class="form-group">
												<label>Status:<span style="color:red;font-size:18px;">*</span></label>
												<select class="form-control" name="status" id="status" onchange="hidemark(this.value);">
													<option value="">--Select Status--</option>
													
													<?php if(!empty ($permissions)){
														if(!empty($buildingPlan)){
															foreach($permissions as $permission){
																if($permission['id'] == 112 || $permission['id'] == 121 || $permission['id'] == 122 || $permission['id'] == 133 || $permission['id'] == 146 || $permission['id'] == 147){
																	
																	}else{
																?>
																
																<option <?php echo ($permission['id']==set_value("status")) ? 'selected' : ''; ?> value="<?php echo $permission['id']; ?>"><?php echo $permission['privilege_name']; ?></option> 
															<?php }	}
														}
													}?>
												</select>
											</div>	
											<?php
											$buildingPlan['form1a_reupload'] = 1;
												if( $_POST['form1a_reupload'] == 1 ){
														$checked="checked";
														}else{
														$checked="";
													}
												if( $_POST['publish_check'] == 1 ){
														$checked_blue="checked";
														}else{
														$checked_blue="";
													}		


												if($_POST['status'] == 37){
													$disp ='';
												}else{
													$disp ='none';
												}	
											?>

											<div class="form-group" id="form1a_reupload_div" style="display:<?= $disp; ?>">
												<label  for="blueprint_check">
													<input type="checkbox" <?php echo $checked_blue; ?> name="publish_check" id="blueprint_check"  value="1"> Do the establishment require to upload blueprint again ?
												</label>
												<br>
												<label  for="form1a_reupload">
													<input type="checkbox" <?php echo $checked; ?> name="form1a_reupload" id="form1a_reupload" value="1"> Do the establishment require to update FORM-1-A again ?
												</label>
												
											</div>


											<div class="verification_hide">
												<?php if($buildingPlan['final_status'] != 1){?>
													<div class="form-group">
														<label>Please Select application processed percentage (for Saral Shasan):</label>
														<select class="form-control" name="level">
															<option value='30' <?php if($buildingPlan['progress_level'] == 30 || $this->input->post('level') == 30){ echo "selected"; }?>>30%</option>
															<option value='50' <?php if($buildingPlan['progress_level'] == 50 || $this->input->post('level') == 50){ echo "selected"; }?>>50%</option>
															<option value='80' <?php if($buildingPlan['progress_level'] == 80 || $this->input->post('level') == 80){ echo "selected"; }?>>80%</option>
														</select>
													</div>
												<?php }?>
												<div class="form-group" id="markk">
													<label>Marked To:<span style="color:red;font-size:18px;">*</span></label>
													<div class="markto">
														<div class="col-md-12 mark-deta">
															<?php if(!empty($departmentofficers)){
																foreach($departmentofficers as $markTo){
																	if($markTo == $_SESSION['department']['job_id'] || $markTo == 0){
																		continue;
																	}
																	$addtnl	=	array();
																	$admin	=	$this->factorydetail_model->getAdminByJob($markTo);													
																	$admjob	=	$this->factorybuilding_model->getAdminFBPCount($markTo);
																	$ofcdetails 	=	getOffc($markTo);
																	if(!empty($admin['additional_charges'])){
																		$addtnl			=	explode(",",$admin['additional_charges']);													
																	}
																	if(!empty($admin)){
																		if($admin['additional_charges'] != "" && in_array("-".$markTo."-",$addtnl)){
																			foreach($addtnl as $addnl){
																				$job_details	=	$this->factorydetail_model->getJobDetail(str_replace('-','',$addnl),12);
																				$jurisdiction	=	explode(",",str_replace("-","",$job_details['director_area_id'])); 
																				if(in_array($factory_info['factory_reg_director_circle'] , $jurisdiction)){
																					$name 	=	$admin['admin_name']."(".$admin['admin_post']."- Additional)";
																				}
																			}															
																		}
																		else{
																			$name 	=	$admin['admin_name']."(".$admin['admin_post'].")";
																		}
																		
																		if($admjob['fbp_officers'] == 2 && $_SESSION['department']['job_id'] != 157){
																			$name 	=	'Concerned Officer';
																		}
																	}
																	else{
																		$name 	=	"Vacant(".$ofcdetails['title'].")"; 
																	}	
																?>
																<label>
																	<input type="radio" name="assigned_to" id="assigned_to" value="<?php echo $markTo?>" <?php echo set_radio("assigned_to",$markTo);?>/>
																	<input type="hidden" name="marked_name" id="marked_name" value="<?php echo $name;?>">
																	<span><strong><?php echo $name; ?></strong></span>
																</label>
																
															<?php }}?>
														</div>
													</div>
												</div>

												
												<div class="col-md-4" id="lc_purpose_container" style="display: none; margin-top: 15px; padding-left: 0;">
													<div class="form-group">
														<label>Proposed Action<span class="text-danger">*</span></label>
														<select class="form-control" name="lc_purpose" id="lc_purpose">
															<option value="">Select Proposed Action</option>
															<?php if(!empty($lc_purposes)) { foreach($lc_purposes as $purpose) { ?>
																<option value="<?php echo $purpose['id']; ?>"><?php echo $purpose['action_name']; ?></option>
															<?php } } ?>
														</select>
														<div class="error" id="lc_purpose_error" style="color: red; display: none;">Please select the purpose.</div>
													</div>
												</div>

												
												<div class="form-group file_upload" style="position:relative;">
													<label for="exampleInputFile">Upload File</label>
													<input type="file" name="document" />
													<input type="hidden" id="document_upload" name="document_upload" value="<?php echo set_value('document_upload');?>"/>
													<?php if(!empty(set_value('document_upload'))) { ?>
														<div id="document" >
															<a target= "_blank" href="<?php echo STORAGE_URL.set_value('document_upload');?>" >Click to view</a>
														</div>
													<?php } ?>
													<span class="allowed_class">(Only .doc .docx .pdf allowed of max size 2 MB)</span>	
												</div>
											</div>
											<div class="verification_show">
												
												<div class="clearfix"></div>
												<div class="col-md-12">
													<div class="form-group">
														<label>Assign Verification to:</label>
														<div class="clearfix"></div>
														<?php if(!empty($verification_officers)){?>
															<?php foreach($verification_officers as $vofficer){
																if($vofficer['job_id']  == $_SESSION['department']['job_id']){
																	continue;
																}
																$admindetail = getOfficerNameByJobid($vofficer['job_id']);
															?>
															<div class="radio">
																<label>
																	<input type="radio" name="app_verifymark" id="app_verifymark" value="<?php echo $vofficer['job_id']?>" <?php echo set_radio("app_verifymark",$vofficer['job_id']);?>/>
																	<?php echo $admindetail; ?>
																</label>
															</div>
															<?php }?>
															<?php echo form_error('app_verifymark', '<div class="error">', '</div>'); ?>
														<?php }?>												
													</div>
												</div>
												<!-- <div class="clearfix"></div>
													<div class="col-md-6">
													<div class="factory_upload_form_verify">
													<div class="form-group upload_reciept">
													<label style="margin-bottom: 10px;">Upload Document(Only jpeg,jpg,png,pdf allow)</label>
													<input type="hidden" name="verifyfactoryid" id="verifyfactoryid" value="<?php echo $factoryInfo['factory_reg_id']; ?>" />
													<input type="hidden" name="verifylicenseid" id="verifylicenseid" value="<?php echo $licenseId; ?>" />
													<input id="verification_doc_photo" type="file" name="verify_doc" value="<?php echo set_value('verification_doc_image') ?>">
													<input type="hidden" name="verify_doc_image" value="<?php echo set_value('verification_doc_image'); ?>"/>
													<?php echo form_error('verify_doc_image', '<div class="error">', '</div>'); ?>
													</div>
													
													</div>
												</div>-->
												
											</div>
										</div><!-- /.box-body -->
										<div class="box-footer">
											
											<input type="hidden" value="<?php echo $complaint_id; ?>" name="complaint_id" id="complaint_id" />
											<input type="hidden" value="<?php echo $factory_id;?>" name="factoryregid" id="factoryregid" />
											<button class="btn btn-primary pull-right" type="submit">Submit</button>
										</div>
										<div class="modal fade"  id="verification_confirm" tabindex="-1" role="dialog" aria-labelledby="verification_confirm" aria-hidden="true"  >
											<div class="modal-dialog">
												<div class="modal-content">
													<form method="POST" action="" id="formverification" >
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title custom_align" id="Heading" style="text-align: center !important;"></h4>
														</div>
														<div class="modal-body" style="padding: 20px 30px 20px 14px;">
															
															<div class="row">
																<div class="col-md-12" style="padding-left: 15px;">
																	<div class="form-group required">
																		<p style=" background: antiquewhite; font-size: 15px;  padding: 11px; font-weight: 700;"> Reply for current verification is pendig so Are you sure you want to take action.
																		</div>
																	</div>
																</div> 
															</div>
															<div class="modal-footer ">
															<button type="button" class="btn btn-warning" onclick='applystatus()'></span>YES</button>
															<button type="button" class="btn btn-danger" data-dismiss="modal"><span ></span> No</button>
														</div>
													</form>
												</div>
												<!-- /.modal-content --> 
											</div>
										</div>	
										<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title" id="myModalLabel">Submit Your OTP</h4>
													</div>
													<div class="modal-body">
														<div class="form-group">
															<div class="input-group my-colorpicker2 colorpicker-element">
																<input type="text" class="form-control numbersOnly" name="otp" placeholder="OTP" maxlength="6" value="" />
																<span class="input-group-btn">
																	<button class="btn btn-primary btn-flat otp-btn" type="button">Submit OTP</button>
																</span>                                        
															</div>
															<?php echo form_error('otp'); ?>      
															<?php 
																$phone = $this->session->userdata['department']['admin_phone'];
																$phone[2] = 'x'; $phone[3] = 'x'; $phone[3] = 'x'; 
																$phone[4] = 'x'; $phone[5] = 'x'; $phone[6] = 'x'; 
																echo '<p>OTP sent to your Mobile No. ('.$phone.')</p>';
																//print_r($_SESSION['building_otp']);
															?>							
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div><!-- /.box -->
								<?php //} ?>
							<?php //} ?>
						<?php //} ?>
					</div><!-- /.box-body -->
				</div>
			</form>
			
			<?php /*if($buildingPlan['final_status'] == 1 && $buildingPlan['jd_comment_status'] == 0 && $_SESSION['department']['job_id'] == $buildingPlan['jd_officer']){?>	
				<?php 	
					$expirydate		=	date('Y-m-d',strtotime($buildingPlan['modified_date'].'+10 days'));
					$current		=	date('Y-m-d'); 
					if($expirydate >= $current){
					?>
					<div class="row">
						<div class="col-md-12">
							<form method="post" action="<?php echo base_url();?>department/factorybuilding/submitJDComment">
								<div class="commenting">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Please submit your comments on the application below and update the status</h3>
										</div><!-- /.box-header -->
										<div class="box-body pad">													
											
											<div class="col-md-12">
												<div class="form-group">
													<textarea class="textarea" placeholder="Place some text here" required name="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo set_value("description");?></textarea>
													<?php echo form_error('description', '<div class="error">', '</div>'); ?>
												</div>
											</div>
											
											<div class="col-md-12">
												<div class="form-group">
													<label>Mark to:</label>
													<div class="clearfix"></div>
													<div class="radio">
														<?php $lcadmin	=	$this->factorydetail_model->getAdminByJob(157);	
														$lcname 	=	$lcadmin['admin_name']."(".$lcadmin['admin_post'].")";?>
														<label>
															<input type="radio" name="" id="app_mark" checked disabled value="157"/>
															<?php echo $lcname; ?>
														</label>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<input type="hidden" value="<?php echo $complaint_id;?>" name="complaint_id"/>
												<input type="submit" value="Process" name="submitComment" class="btn btn-primary pull-right"><br>
											</div>
										</div>
									</div>
								</div>
							</form>										
						</div>
					</div>
				<?php }?>
			<?php }*/?>
		</section><!-- /.content -->
	</div>
	<script>
		
		var plan_id = '<?= $complaint_id ?>';
		$(document).ready(function(){
			$('#publish_checkbox').click(function(){
				if($(this).prop("checked") == true){
					var value = 1;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url("department/Factorybuilding/blueprintChecked"); ?>",
						async: true,
						data: {
							action1: value,plan_id:plan_id // as you are getting in php $_POST['action1'] 
						},
						success: function (msg) {
							
						}
					});
				}
				else if($(this).prop("checked") == false){
					var value = 0;
					$.ajax({
						type: "POST",
						url: "<?php echo base_url("department/Factorybuilding/blueprintChecked"); ?>",
						async: true,
						data: {
							action1: value,plan_id:plan_id // as you are getting in php $_POST['action1'] 
						},
						success: function (msg) {
							
						}
					});
				}
			});
		});
		$('#myModal').on('shown.bs.modal', function () {
			$('input[name="otp"]').focus();
		});

		$('input[name="otp"]').on('keypress', function(e) {
			if(e.which === 13 || e.keyCode === 13) {
				e.preventDefault();
				$('.otp-btn').trigger('click');
			}
		});
		<?php if (form_error('otp')) { ?>
			
			$(window).load(function () {
				$('#myModal').modal({
					//backdrop: 'static',
					//keyboard: true, 
					show: true,
					}).on('hidden.bs.modal', function (e) {
					$('input[name="otp_val"]').val("");
				});
			});
			
			$(".otp-btn").click(function () {
				var value = $('input[name="otp"]').val();
				$.get("<?php echo base_url('department/factorybuilding/verifyOTP'); ?>", {otp_val: value}, function (res) {
					if ($.trim(res) == 'true') {
						$('input[name="otp_val"]').val(value);
						$('#frm').submit();
						} else {
						var txt = 'Invalid OTP. <a href="javascript:void(0)" onclick="refresh();" >Click here to resend.</a>';
						$(".error-msg").html(txt);
					}
				});
			});
			
			function refresh() {
				window.location.reload(true);
			}
			
		<?php }?>
		
		$(document).ready(function(){
			$("#hearing_date").datepicker({
				format: 'yyyy-mm-dd',
			});
			
		}) ;
		/* function hidemark(id){
			//alert(id);
			//alert(id);
			if(id == 34 || id == 36 || id == 37 || id == 139){			
			$("#markk").hide();
			}else{
			$("#markk").show();
			}
			
		} */
		$(document).ready(function(){
			var id = $("select[name=status]").val();
			$('#verification_confirm').modal('hide');
			if(id == 34 || id == 36 || id == 37 || id == 139){			
				$("#markk").hide();
				$(".verification_show").hide();
				$(".verification_hide").show();
				}else if(id == 230){
				$(".verification_hide").hide();
				$(".verification_show").show();
				}else{
				$("#markk").show();
				$(".verification_show").hide();
				$(".verification_hide").show();
			}
		});
		function applystatus(){
			var id = $("select[name=status]").val();
			$('#verification_confirm').modal('hide');
			if(id == 34 || id == 36 || id == 37 || id == 139){			
				$("#markk").hide();
				$(".verification_show").hide();
				$(".verification_hide").show();
				}else if(id == 230){
				$(".verification_hide").hide();
				$(".verification_show").show();
				}else{
				$("#markk").show();
				$(".verification_show").hide();
				$(".verification_hide").show();
			}
		}
		function hidemark(id){
			var factid = $('#factoryregid').val();
			var lid = $('#complaint_id').val();
			//alert(lid);
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url() ?>department/factorybuilding/checkpopup_condition",
				data: 'verifyfactoryid='+factid+'&verifylicenseid='+lid,
				dataType: "html",
				success: function (res) {
                    console.log(res); 
					if($.trim(res) == 'yes'){
						$('#modal_error_verify').addClass("modal_style");
						$('#verification_confirm').modal('show');
						
						}else{
						
						if(id == 34 || id == 36 || id == 37 || id == 139){			
							$("#markk").hide();
							$(".verification_show").hide();
							$(".verification_hide").show();
							}else if(id == 230){
							$(".verification_hide").hide();
							$(".verification_show").show();
							}else{
							$("#markk").show();
							$(".verification_show").hide();
							$(".verification_hide").show();
						}
					}
				}
			});		
			//alert(id);
			//alert(id);
			
			
		}
		
		$('input[name="doc_file"]').on('change',function(e){ startUpload(e,this,'factory_building/factory_building_signed_cert'); });
		function startUpload(e,thiss,path){
			
			$(".error").hide();
			var fname = $(thiss).attr("name");
			$('input[name="'+fname+'name_image"]').val('');
			$('#'+fname).remove();
			var base_url = "<?php echo base_url(); ?>";
			e.preventDefault();
			var formData = new FormData();
			formData.append(fname, $(thiss)[0].files[0]);        
			formData.append('name',fname);        
			formData.append('path',path); 
			if($(thiss)[0].files[0].size>2097152) {
				$(thiss).after('<p class="acard-error error" style="position: relative;">The file you are attempting to upload is larger than the permitted size.</p>');
				$(thiss).val("");
				return false;
			}
			$("input[type=submit]").hide();
			$(thiss).attr("disabled",true);
			$.ajax({
				url: "<?php echo base_url("department/cess/uploadFiles"); ?>",
				type: "POST",
				beforeSend: function (xhr) {
					$(thiss).before('<img class="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>" style="width:30px" >');
				},  
				complete: function (jqXHR, textStatus ) {
					$(".loader").hide();    
				},
				data:  formData,
				contentType: false,
				cache: false,
				processData:false,            
				success: function(data) {
					$("input[type=submit]").show();
					$(thiss).attr("disabled",false);
					var res = jQuery.parseJSON(data);
					$(thiss).after("");
					if(res.result.status=='0'){
						$(thiss).after('<p id="'+fname+'" style="color:red;">'+res.result.msg+'</p>');
						} else {
						var path = res.result.path;
						$('input[name="'+fname+'name_image"]').val(path);
						$(thiss).after('<div id="'+fname+'" ><img width="30" vspace="5" border="0" hspace="5" align="absmiddle" src="'+res.result.icon+'" /><a style="margin:10px;cursor:grab;font-weight: bold;" onclick="remove_file(\''+fname+'\')" >Remove</a></div>');
						//if($("#proof_ration_card").is(":checked")) {
						//$('input[name="age_verify_document_image"]').val(path);	
						//}
					}
					console.log(data);                 
				}
			});
		}
		function remove_file(fname) {
			//alert(fname);
			$("#"+fname).empty();
			$("#"+fname).remove();
			$('input[name="'+fname+'_image"]').val("");
			$('input[name="'+fname+'"]').val("");
		} 
		
		
		function remove_file_optional_doc(fname,path,folder) {
			$("#"+fname).empty();
			$("#"+fname).remove();
			$('input[id="'+fname+'"]').val("");
			$('input[name="'+fname+'"]').val("");
			$('input[name="document_upload"]').val("");
		}
		$('input[name="document"]').on('change',function(e){ startUploadOptDoc(e,this,'document'); });
		
		function startUploadOptDoc(e,thiss,path){
			$('.btn-primary').attr('disabled',true);
			var fname = $(thiss).attr("name");
			var base_url = "<?php echo base_url(); ?>";		
			var STORAGE_URL = "<?php echo STORAGE_URL; ?>";
			e.preventDefault();
			var formData = new FormData();
			formData.append(fname, $(thiss)[0].files[0]);        
			formData.append('name',fname);        
			formData.append('path',path); 	
			formData.append('foldername','additionaldoc'); 	
			var id = $(thiss).attr("attr");    
			var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')
			var file = filename.split('.')[0];
			
			$(".error").hide();
			
			if($(thiss)[0].files[0].size>2097152) {
				$(thiss).after('<p class="acard-error error" style="position: relative;">The file you are attempting to upload is larger than the permitted size.</p>');
				$('input[name="document"]').val("");
				return false;
			}
			
			$.ajax({
				url: 	"<?php echo base_url("department/factorybuilding/uploadFiles"); ?>",
				type: 	"POST",  
				data:  	formData,
				contentType: false,
				cache: 	false,
				processData:false,  
				beforeSend: function (xhr) {
					$(thiss).before('<img class="loader" src="<?php echo base_url('assets/images/loading.gif'); ?>" style="width:30px" >');
				},
				complete: function (jqXHR, textStatus) {
					$(".loader").hide();
				},          
				success: function(data) {                
					var res = jQuery.parseJSON(data);
					$(thiss).after("");
					if(res.result.status=='0'){
						$(thiss).after('<p class="error" >'+res.result.msg+'</p>');
						$('.btn-primary').attr('disabled',false);
						$('input[name="document"]').val("");
						} else {
						$('.btn-primary').attr('disabled',false);
						var path = res.result.path;
						$('input[name="document_upload"]').val(path);
						$(thiss).after('<div id="'+fname+'" ><img width="30" vspace="5" border="0" hspace="5" align="absmiddle" src="'+res.result.icon+'" /><a href="javascript:void(0)" onclick="remove_file_optional_doc(\''+fname+'\',\''+path+'\',\''+id+'\')" >Remove</a></div>');
					}
					console.log(data);                 
				}
			});
		}
		
		$('.save_comnt').click(function(){ 
			$.ajax({
				type: "POST",
				url: "<?php echo base_url("department/Factorybuilding/saveComment"); ?>",
				async: true,
				data: {
					comment: $('#description').val() ,
					planid : plan_id
				},
				success: function (msg) {
					
				}
			});
		});

	</script>	
		<script>
			$('#status').change(()=>{
				let status_selected = Number($('#status').val());
				if(status_selected == 37){
					$('#form1a_reupload_div').show();
				}else{
					$('#form1a_reupload_div').hide();
				}
			})
		</script>														


<script>
		$(document).on('change', 'input[name="assigned_to"]', function() {
			if($(this).val() == '157') {
				$('#lc_purpose_container').slideDown();
				$('#lc_purpose').prop('required', true);
			} else {
				$('#lc_purpose_container').slideUp();
				$('#lc_purpose').prop('required', false).val('');
				$('#lc_purpose_error').hide();
			}
		});

		$(document).ready(function() {
			if($('input[name="assigned_to"]:checked').val() == '157'){
				$('#lc_purpose_container').show();
				$('#lc_purpose').prop('required', true);
			}
			
			$('#frm').on('submit', function(e) {
				if($('input[name="assigned_to"]:checked').val() == '157') {
					if(!$('#lc_purpose').val()) {
						e.preventDefault();
						$('#lc_purpose_error').show();
						
					}
				}
			});
		});
	</script>
