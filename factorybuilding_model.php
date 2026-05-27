<?php
	
	if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
	class FactoryBuilding_model extends CI_Model {
		
		public function __construct() {
			parent::__construct();
			//$this->db = $this->load->database('inspectionDB', true);			
			//$this->otherdb = $this->load->database('otherdb',true);  
			$this->slaveDB = $this->load->database('slave', true);        
		}
		
		/*
			*	AddedDate: 22 april 2016
			*	AddedBy: Harjot
			*	FunctionName: getjuristrictions
			*	Purpose: get juristrictions against job_id and distt ids against the juristriction
		*/
		
		public function getjuristrictions(){
			$job_id = $this->session->userdata['department']['job_id'];
			$qry = $this->db->select('director_area_id');
			$this->db->from('labour_admin_job_detail');
			$this->db->where(array('labour_admin_job_detail.job_id'=> $job_id , 'labour_admin_job_detail.job_type' => '12'));
			$areas = $this->db->get()->row_array();
			$admin_district			=	explode(',',$areas['director_area_id']);
			return $admin_district;			
		}
		/*
			*	AddedDate: 22 April 2016
			*	AddedBy: Harjot
			*	FunctionName: getTotalComplaints
			*	Purpose: get total number of Complaints
		*/
		// public function getTotalComplaints($type){
		// 	$dept_officer			=	$_SESSION['department'];
		// 	$app_divider			=	"";
		// 	$cndtn				=	"";
		// 	if(isset($dept_officer['privileges'][12])){
		// 		$admin_privileges 		=	explode(",",str_replace("-","",$dept_officer['privileges'][12]));				
		// 	}
		// 	if(isset($dept_officer['app_divider'][12])){
		// 		$app_divider 		=		str_replace('-','',$dept_officer['app_divider'][12]);
		// 		$appdiv				=		explode(",",$app_divider);
		// 	}
		
		// 	// permission - issue certificate for dlcc not eec (fetch unpublished license appln of only dlcc)
		// 	$issueCert 			=	"";
		// 	if(in_array(112,$admin_privileges) && in_array(2,$appdiv)){
		// 		$issueCert		=	" factory_registrations.app_divider = 2";
		// 	}
		// 	elseif(!in_array(112,$admin_privileges)){
		// 		$issueCert		=	" factory_registrations.app_divider IN ($app_divider)";
		// 	}
		
		// 	// permission - issue objection for dlcc not eec (fetch unpublished observation appln of only dlcc)
		// 	$issueObj 			=	"";
		// 	if(in_array(133,$admin_privileges) && in_array(2,$appdiv)){
		// 		$issueObj		=	" factory_registrations.app_divider = 2";
		// 	}
		// 	elseif(!in_array(133,$admin_privileges)){
		// 		$issueObj		=	" factory_registrations.app_divider IN ($app_divider)";
		// 	}
		
		// 	// permission - issue rejection for dlcc not eec (fetch unpublished rejection appln of only dlcc)
		// 	$issueRej 			=	"";
		// 	if(in_array(147,$admin_privileges) && in_array(2,$appdiv)){
		// 		$issueRej		=	" factory_registrations.app_divider = 2";
		// 	}
		// 	elseif(!in_array(147,$admin_privileges)){
		// 		$issueRej		=	" factory_registrations.app_divider IN ($app_divider)";
		// 	}
		
		// 	if(isset($dept_officer['app_divider'][12])){
		// 		$app_divider 		=	str_replace('-','',$dept_officer['app_divider'][12]);
		// 		$cndtn				=	"factory_registrations.app_divider IN ($app_divider)";
		// 	}
		// 	$distt = $this->getjuristrictions();
		// 	if(!empty($type == 'unassigned'))
		// 	{
		// 		$this->db->where('assigned_to','18888888');
		// 		$result = $this->db->select('*')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->get()->num_rows();
		// 		return $result;
		// 	}
		// 	if(!empty($type == 'assigned')){
		// 		$job_id = $this->session->userdata['department']['job_id'];
		// 		$query = $this->db->select('labour_factorybuilding_decisions.*,labour_factorybuilding_plan.id')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->like('assigned_to',$job_id)->where('labour_factorybuilding_plan.status',1)->where('labour_factorybuilding_plan.final_status',3)->get()->result_array();
		// 		if(empty($query)) {			
		// 			return false;
		// 		}
		// 		$complaint_id = array();
		// 		foreach($query as $que){
		// 			$complaint_id[]= $que['complaint_id'];
		// 		}
		// 		$complaint_ids = implode(',',$complaint_id);
		// 		$result = $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->where_in('labour_factorybuilding_plan.id',$complaint_ids,false)->get()->row_array();	
		// 		return @$result['total'];
		
		// 	}
		// 	if(!empty($type == 'newtab')){
		// 		$where 	=	"labour_factorybuilding_plan.final_status NOT IN (2,5,10,0) AND labour_factorybuilding_plan.status = 1";
		// 		return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where($where)->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where_in('factory_registrations.app_divider',array(1,2))->get()->row_array()['total'];
		// 	} 
		// 	if(!empty($cndtn)){
		// 		if(!empty($type =='new')){
		// 			//'labour_factorybuilding_plan.checkarchitect'=>1,
		// 			return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1))->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where($cndtn)->get()->row_array()['total'];				
		// 		}
		
		// 		if(!empty($type=='process')){							
		// 			return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where(array('labour_factorybuilding_plan.final_status'=>3,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_decisions.assigned_to'=>''))->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where($cndtn)->get()->row_array()['total'];				
		// 		}
		
		// 		if(!empty($issueObj) && !empty($issueCert)){
		// 			@$this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false);			
		// 		}
		// 		else{
		// 			return 0;
		// 		}
		
		
		// 		if(!empty($type=='hepc')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1));
		// 			$this->db->group_start();
		// 			$this->db->where("factory_registrations.factory_reg_director_circle",NULL);
		// 			$this->db->or_where("factory_registrations.factory_reg_director_circle",0);			
		// 			$this->db->group_end();				
		// 			$this->db->where('factory_registrations.projectid != ','');
		// 		}
		// 		if(!empty($type=='reject')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'5'));
		// 		}
		// 		if(!empty($type=='close')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'2'));
		// 		}
		// 		if(!empty($type=='unpublic') && !empty($issueCert)){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'8'));
		// 			$this->db->where($issueCert);
		// 		}
		// 		if(!empty($type=='objection')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'4'));
		// 		}
		// 		if(!empty($type=='unpub_objection') && !empty($issueObj)){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'7'));
		// 			$this->db->where($issueObj);
		// 		}
		// 		if(!empty($type=='unpubrej') && !empty($issueRej)){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'11'));
		// 			$this->db->where($issueRej);
		// 		}
		// 		if(!empty($type=='reply')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'6'));
		// 		}		
		// 		if($type != 'unpublic' && $type != 'unpub_objection' && $type != 'unpubrej'){
		// 			$this->db->where($cndtn);
		// 		}
		// 		$result=$this->db->where_in()->get()->row_array();				
		// 		return $result['total'];
		// 	}
		// 	return 0;
		// }
		
		
		public function getTotalComplaints($type, $lc_filter = NULL){
			$dept_officer			=	$_SESSION['department'];
			$app_divider			=	"";
			$cndtn				=	"";
			if(isset($dept_officer['privileges'][12])){
				$admin_privileges 		=	explode(",",str_replace("-","",$dept_officer['privileges'][12]));				
			}
			if(isset($dept_officer['app_divider'][12])){
				$app_divider 		=		str_replace('-','',$dept_officer['app_divider'][12]);
				$appdiv				=		explode(",",$app_divider);
			}
			
			// permission - issue certificate for dlcc not eec (fetch unpublished license appln of only dlcc)
			$issueCert 			=	"";
			if(in_array(112,$admin_privileges) && in_array(2,$appdiv)){
				$issueCert		=	" factory_registrations.app_divider = 2";
			}
			elseif(!in_array(112,$admin_privileges)){
				$issueCert		=	" factory_registrations.app_divider IN ($app_divider)";
			}
			
			// permission - issue objection for dlcc not eec (fetch unpublished observation appln of only dlcc)
			$issueObj 			=	"";
			if(in_array(133,$admin_privileges) && in_array(2,$appdiv)){
				$issueObj		=	" factory_registrations.app_divider = 2";
			}
			elseif(!in_array(133,$admin_privileges)){
				$issueObj		=	" factory_registrations.app_divider IN ($app_divider)";
			}
			
			// permission - issue rejection for dlcc not eec (fetch unpublished rejection appln of only dlcc)
			$issueRej 			=	"";
			if(in_array(147,$admin_privileges) && in_array(2,$appdiv)){
				$issueRej		=	" factory_registrations.app_divider = 2";
			}
			elseif(!in_array(147,$admin_privileges)){
				$issueRej		=	" factory_registrations.app_divider IN ($app_divider)";
			}
			
			// app divider assigned to department officer
			if(isset($dept_officer['app_divider'][12])){
				$app_divider 		=	str_replace('-','',$dept_officer['app_divider'][12]);
				$cndtn				=	"factory_registrations.app_divider IN ($app_divider)";
			}
			
			if(!empty($type =='sentverification')){
				$this->db->where('verification_officer_jobid',$_SESSION['department']['job_id']);
				$this->db->where('reply_status',0);
				$this->db->from("factoryplan_application_verification as veri");
				$this->db->join("labour_factorybuilding_plan as plan", "veri.plan_id  = plan.id");
				$this->db->join("factory_registrations as reg", "veri.factory_reg_id = reg.factory_reg_id");
				$query = $this->db->get();
				return $query->num_rows();
			}
			
			if(!empty($type == 'unassigned'))
			{
				$this->db->where('assigned_to','18888888');
				$result = $this->db->select('*')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->get()->num_rows();
				return $result;
			}
			if(!empty($type == 'assigned')){
				$job_id = $this->session->userdata['department']['job_id'];
				$query = $this->db->select('labour_factorybuilding_decisions.*,labour_factorybuilding_plan.id')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->like('assigned_to',$job_id)->where('labour_factorybuilding_plan.status',1)->where('labour_factorybuilding_plan.final_status',3)->get()->result_array();
				if (!empty($lc_filter)) {
					$subquery = "(
						SELECT max_lc.app_id, max_lc.markedto_proposeId
						FROM marked_applications_lc max_lc
						INNER JOIN (
							SELECT MAX(id) as latest_id 
							FROM marked_applications_lc 
							WHERE act = 'factory_building_plan'
							GROUP BY app_id
						) latest ON max_lc.id = latest.latest_id
					) latest_marked_reason";
					$this->db->join($subquery, 'latest_marked_reason.app_id = labour_factorybuilding_plan.id', 'left');
					
					$this->db->where('latest_marked_reason.markedto_proposeId', $lc_filter);
				}
							
				if(empty($query)) {			
					return false;
				}
				$complaint_id = array();
				foreach($query as $que){
					$complaint_id[]= $que['complaint_id'];
				}
				$complaint_ids = implode(',',$complaint_id);
				$result = $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->where_in('labour_factorybuilding_plan.id',$complaint_ids,false)->get()->row_array();	
				return @$result['total'];
				
			}
			if(!empty($type =='jdpendency')){
				$job_id = $this->session->userdata['department']['job_id'];	
				if(!empty($cndtn)){				
					return $this->db->select('count(*) as total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.jd_comment_status'=>0,'labour_factorybuilding_plan.jd_officer'=>$job_id))->where($cndtn)->get()->row_array()['total'];
				}						
			}
			if(!empty($cndtn)){
				$distt = $this->getjuristrictions();
				if(!empty($type != 'hepc') && ($_SESSION['department']['job_id'] != 468 && $_SESSION['department']['job_id'] != 467)){
					$this->db->group_start();
					$this->db->where('step1_officer',$_SESSION['department']['job_id']);
					$this->db->or_where('step2_officer',$_SESSION['department']['job_id']);
					$this->db->or_where('step3_officer',$_SESSION['department']['job_id']);
					$this->db->or_where('step4_officer',$_SESSION['department']['job_id']);
					$this->db->group_end();
				}
				
				if(!empty($type != 'hepc') && ($_SESSION['department']['job_id'] == 468 || $_SESSION['department']['job_id'] == 467)){
					$this->db->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false);
				}
				
				if(!empty($type == 'twentyfive')){
					// $where 	=	"labour_factorybuilding_plan.final_status NOT IN (2,5,10,0) AND labour_factorybuilding_plan.status = 1";
					// return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where($where)->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where_in('factory_registrations.app_divider',array(1,2))->get()->row_array()['total'];
					
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					$job_id = $this->session->userdata['department']['job_id'];
					
					
					$where 	=	"(labour_factorybuilding_plan.final_status = '1' or (labour_factorybuilding_plan.final_status IN (3,8,4,7,11,6) AND labour_factorybuilding_plan.status = 1 
					and (`assigned_to` = $job_id   or `assigned_to` = '' or `assigned_to` = '18888888')))";
					$this->db->where('date(labour_factorybuilding_plan.modified_date) >= DATE_ADD(CURDATE(),INTERVAL -25 Day) AND date(labour_factorybuilding_plan.modified_date) < DATE_ADD(CURDATE(),INTERVAL -25 Day)');
					return 
					$this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')
					->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id','left')->where($where)->where_in('factory_registrations.app_divider',array(1,2))->order_by('modified_date')->get()->row_array()['total'];
				}
				if(!empty($type == 'thirtytwo')){
					// $where 	=	"labour_factorybuilding_plan.final_status NOT IN (2,5,10,0) AND labour_factorybuilding_plan.status = 1";
					// $this->db->where('date(labour_factorybuilding_plan.modified_date) <= DATE_ADD(CURDATE(),INTERVAL -35 Day)'); 
					
					// return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where($where)->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where_in('factory_registrations.app_divider',array(1,2))->get()->row_array()['total'];
					
					
					$job_id = $this->session->userdata['department']['job_id'];
					
					
					$where 	=	"(labour_factorybuilding_plan.final_status = '1' or (labour_factorybuilding_plan.final_status IN (3,8,4,7,11,6) AND labour_factorybuilding_plan.status = 1 
					and (`assigned_to` = $job_id   or `assigned_to` = '' or `assigned_to` = '18888888')))";
					$this->db->where('date(labour_factorybuilding_plan.modified_date) < DATE_ADD(CURDATE(),INTERVAL -32 Day)');
					
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					return 
					$this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')
					->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id','left')->where($where)->where_in('factory_registrations.app_divider',array(1,2))->order_by('modified_date')->get()->row_array()['total'];					 
				}
				if(!empty($type == 'newtab')){
					$job_id = $this->session->userdata['department']['job_id'];				
					$where 	=	"(labour_factorybuilding_plan.final_status = '1' or (labour_factorybuilding_plan.final_status IN (3,8,4,7,11,6) AND labour_factorybuilding_plan.status = 1 
					and (`assigned_to` = $job_id   or `assigned_to` = '' or `assigned_to` = '18888888')))";
					
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					
					return 
					$this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')
					->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id','left')->where($where)->where_in('factory_registrations.app_divider',array(1,2))->get()->row_array()['total'];
				}
				
				if(!empty($type =='new')){
					if(!empty($cndtn)){				
						//$jdwhere 	=	'(labour_factorybuilding_plan.jd_officer = 0 OR labour_factorybuilding_plan.jd_comment_status = 1)'; 
						//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
						return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.stability_application'=>0))->where($cndtn)->get()->row_array()['total'];
					}						
				}
				if(!empty($type =='stability')){
					if(!empty($cndtn)){				
						return $this->db->select('count(*) as total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.stability_application'=>1))->where($cndtn)->get()->row_array()['total'];						 
					}						
				}
				if(!empty($type =='pending_scrutiny')){
					if(!empty($cndtn)){				
						//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
						return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>12))->where($cndtn)->get()->row_array()['total'];
					}						
				}		
				
				if(!empty($type=='process')){							
					if(!empty($cndtn)){	
						//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
						return $this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where(array('labour_factorybuilding_plan.final_status'=>3,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_decisions.assigned_to'=>''))->where($cndtn)->get()->row_array()['total'];		
					}						
				}
				if(!empty($issueObj) && !empty($issueCert) && !empty($issueRej)){
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt)
					@$this->db->select('count(*) total')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');			
				}
				else{
					return 0;
				}
				if(!empty($type=='hepc')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1));
					$this->db->group_start();
					$this->db->where("factory_registrations.factory_reg_director_circle",NULL);
					$this->db->or_where("factory_registrations.factory_reg_director_circle",0);			
					$this->db->group_end();				
					$this->db->where('factory_registrations.projectid != ','');
				}
				if(!empty($type=='reject')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'5'));
				}
				if(!empty($type=='close')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'2'));
				}
				
				if(!empty($type=='unpublic') && !empty($issueCert)){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'8'));
					$this->db->where($issueCert);
					
				}
				
				if(!empty($type=='objection')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'4'));
				}
				if(!empty($type=='unpub_objection') && !empty($issueObj)){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'7'));
					$this->db->where($issueObj);
				}
				if(!empty($type=='unpubrej') && !empty($issueRej)){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'11'));
					$this->db->where($issueRej);
				}
				if(!empty($type=='reply')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'6'));
				}		
				if($type != 'unpublic' && $type != 'unpub_objection'){
					$this->db->where($cndtn);
				}
				$result=$this->db->where_in()->get()->row_array();		
				//	echo $this->db->last_query();die();
				return $result['total'];
			}			
			return 0;			
		}
		
		public function gethepcComplaints($type){
			if(!empty($type=='hepc')){
				@$this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id');
				$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>1));
				$this->db->group_start();
				$this->db->where("factory_registrations.factory_reg_director_circle",NULL);
				$this->db->or_where("factory_registrations.factory_reg_director_circle",0);			
				$this->db->group_end();				
				$this->db->where('factory_registrations.projectid != ','');
				$result=$this->db->group_by('labour_factorybuilding_plan.id')->get()->num_rows();
				//echo $this->db->last_query();
				return $result;	
			}
		}
		/*
			*	AddedDate: 21st march 2016
			*	AddedBy: samriti
			*	FunctionName: getcomplaints
			*	Purpose: get all complaints
		*/
		
		public function getapplications($type,$limit,$offset, $lc_filter = NULL){
			$dept_officer			=	$_SESSION['department'];
			$app_divider			=	"";
			$cndtn				=	"";
			
			if(isset($dept_officer['app_divider'][12])){
				$app_divider 		=	str_replace('-','',$dept_officer['app_divider'][12]);
				$cndtn				=	"factory_registrations.app_divider IN ($app_divider)";
				$appdiv				=		explode(",",$app_divider);
			}
			if(isset($dept_officer['privileges'][12])){
				$admin_privileges 		=	explode(",",str_replace("-","",$dept_officer['privileges'][12]));				
			}
			
			// permission - issue certificate for dlcc not eec (fetch unpublished license appln of only dlcc)
			$issueCert 			=	"";
			if(in_array(112,$admin_privileges) && in_array(2,$appdiv)){
				$issueCert		=	" factory_registrations.app_divider = 2";
			}
			elseif(!in_array(112,$admin_privileges)){
				$issueCert		=	" factory_registrations.app_divider IN ($app_divider)";
			}
			
			// permission - issue objection for dlcc not eec (fetch unpublished observation appln of only dlcc)
			$issueObj 			=	"";
			if(in_array(133,$admin_privileges) && in_array(2,$appdiv)){
				$issueObj		=	" factory_registrations.app_divider = 2";
			}
			elseif(!in_array(133,$admin_privileges)){
				$issueObj		=	" factory_registrations.app_divider IN ($app_divider)";
			}
			
			// permission - issue rejection for dlcc not eec (fetch unpublished rejection appln of only dlcc)
			$issueRej 			=	"";
			if(in_array(147,$admin_privileges) && in_array(2,$appdiv)){
				$issueRej		=	" factory_registrations.app_divider = 2";
			}
			elseif(!in_array(147,$admin_privileges)){
				$issueRej		=	" factory_registrations.app_divider IN ($app_divider)";
			}
			
			
			if(!empty($type == 'sentverification')){
				$this->db->limit($limit, $offset);
				$this->db->where('verification_officer_jobid',$_SESSION['department']['job_id']);
				$this->db->where('reply_status',0);				
				$this->db->from("factoryplan_application_verification as veri");
				$this->db->join("labour_factorybuilding_plan as plan", "veri.plan_id  = plan.id");
				$this->db->join("factory_registrations as reg", "veri.factory_reg_id = reg.factory_reg_id");
				$query = $this->db->get();
				return $query->result_array();				
			}
			
			if(!empty($type =='jdpendency')){
				$job_id = $this->session->userdata['department']['job_id'];	
				if(!empty($cndtn)){				
					return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.jd_comment_status'=>0,'labour_factorybuilding_plan.jd_officer'=>$job_id))->where($cndtn)->get()->result_array();
				}						
			}
			
			
			if(!empty($type == 'unassigned'))
			{
				$this->db->limit($limit, $offset);
				$this->db->where('assigned_to','18888888');
				$result = $this->db->select('*')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->get()->result_array();
				return $result;
			}
			if(!empty($type=='hepc')){
				$this->db->limit($limit, $offset);
				@$this->db->select('labour_factorybuilding_plan.*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id');
				$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>1));
				$this->db->group_start();
				$this->db->where("factory_registrations.factory_reg_director_circle",NULL);
				$this->db->or_where("factory_registrations.factory_reg_director_circle",0);			
				$this->db->group_end();				
				$this->db->where('factory_registrations.projectid != ','');
				$result=$this->db->group_by('labour_factorybuilding_plan.id')->get()->result_array();
				
				return $result;	
			}
			if(!empty($type == 'assigned')){
				$this->db->limit($limit, $offset);
				$job_id = $this->session->userdata['department']['job_id'];
				$query = $this->db->select('labour_factorybuilding_decisions.*,labour_factorybuilding_plan.id')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->like('assigned_to',$job_id)->where('labour_factorybuilding_plan.status',1)->where('labour_factorybuilding_plan.final_status',3)->order_by('labour_factorybuilding_decisions.modified')->get()->result_array();				
				if (!empty($lc_filter)) {
					$subquery = "(
						SELECT max_lc.app_id, max_lc.markedto_proposeId
						FROM marked_applications_lc max_lc
						INNER JOIN (
							SELECT MAX(id) as latest_id 
							FROM marked_applications_lc 
							WHERE act = 'factory_building_plan'
							GROUP BY app_id
						) latest ON max_lc.id = latest.latest_id
					) latest_marked_reason";
					$this->db->join($subquery, 'latest_marked_reason.app_id = labour_factorybuilding_plan.id', 'left');
					
					$this->db->where('latest_marked_reason.markedto_proposeId', $lc_filter);
				}
							
				
				if(empty($query)) {
					return false;
				}
				$complaint_id = array();
				foreach($query as $que){
					$complaint_id[]= $que['complaint_id'];
				}
				$complaint_ids = implode(',',$complaint_id);
				$result = $this->db->select('*')->from('labour_factorybuilding_plan')->where_in('labour_factorybuilding_plan.id',$complaint_ids,false)->order_by('modified_date')->get()->result_array();					
				return $result;
			}
			if(!empty($cndtn)){
				
				
				$distt = $this->getjuristrictions();	
				
				$this->db->limit($limit, $offset);
				
				if(!empty($type != 'hepc') && ($_SESSION['department']['job_id'] != 468 && $_SESSION['department']['job_id'] != 467)){
					$this->db->group_start();
					$this->db->where('step1_officer',$_SESSION['department']['job_id']);
					$this->db->or_where('step2_officer',$_SESSION['department']['job_id']);
					$this->db->or_where('step3_officer',$_SESSION['department']['job_id']);
					$this->db->or_where('step4_officer',$_SESSION['department']['job_id']);
					$this->db->group_end();
				}
				
				if(!empty($type != 'hepc') && ($_SESSION['department']['job_id'] == 468 || $_SESSION['department']['job_id'] == 467)){
					$this->db->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false);
				}
				
				if(!empty($type == 'twentyfive')){
					$job_id = $this->session->userdata['department']['job_id'];				
					$where 	=	"(labour_factorybuilding_plan.final_status = '1' or (labour_factorybuilding_plan.final_status IN (3,8,4,7,11,6) AND labour_factorybuilding_plan.status = 1 
					and (`assigned_to` = $job_id   or `assigned_to` = '' or `assigned_to` = '18888888')))";
					$this->db->where('date(labour_factorybuilding_plan.modified_date) >= DATE_ADD(CURDATE(),INTERVAL -32 Day) AND date(labour_factorybuilding_plan.modified_date) < DATE_ADD(CURDATE(),INTERVAL -25 Day)');
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					
					return 
					$this->db->select('labour_factorybuilding_plan.*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')
					->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id','left')->where($where)->where_in('factory_registrations.app_divider',array(1,2))->order_by('modified_date')->get()->result_array();
				}
				if(!empty($type == 'thirtytwo')){
					$job_id = $this->session->userdata['department']['job_id'];
					
					$where 	=	"(labour_factorybuilding_plan.final_status = '1' or (labour_factorybuilding_plan.final_status IN (3,8,4,7,11,6) AND labour_factorybuilding_plan.status = 1 
					and (`assigned_to` = $job_id   or `assigned_to` = '' or `assigned_to` = '18888888')))";
					$this->db->where('date(labour_factorybuilding_plan.modified_date) < DATE_ADD(CURDATE(),INTERVAL -32 Day)');
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					return 
					$this->db->select('labour_factorybuilding_plan.*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')
					->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id','left')->where($where)->where_in('factory_registrations.app_divider',array(1,2))->order_by('modified_date')->get()->result_array();
				}
				
				if(!empty($type == 'newtab')){
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					$where 	=	"labour_factorybuilding_plan.final_status NOT IN (2,5,10,0) AND labour_factorybuilding_plan.status = 1";
					return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where($where)->where($cndtn)->order_by('modified_date')->get()->result_array();
				}
				
				if(!empty($type =='new')){
					//$jdwhere 	=	'(labour_factorybuilding_plan.jd_officer = 0 OR labour_factorybuilding_plan.jd_comment_status = 1)';
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.stability_application'=>0))->where($cndtn)->order_by('modified_date','ASC')->get()->result_array();
				}
				if(!empty($type =='stability')){
					return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.stability_application'=>1))->where($cndtn)->get()->result_array();						
				}
				if(!empty($type =='pending_scrutiny')){
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>12,'labour_factorybuilding_plan.status'=>1))->where($cndtn)->get()->result_array();
				}
				if(!empty($type=='process')){
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where(array('labour_factorybuilding_plan.final_status'=>3,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_decisions.assigned_to'=>''))->where($cndtn)->get()->result_array();
				}
				
				if(!empty($issueObj) && !empty($issueCert) && !empty($issueRej)){
					//->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)
					@$this->db->select('labour_factorybuilding_plan.*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where($cndtn);
				}
				else{
					return 0;
				}
				if(!empty($type=='reject')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'5'));
				}
				if(!empty($type=='close')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'2'));
				}
				if(!empty($type=='objection')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'4'));
				}
				if(!empty($type=='reply')){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'6'));
				}
				if(!empty($type=='unpub_objection') && !empty($issueObj)){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'7'));
					$this->db->where($issueObj);
				}
				if(!empty($type=='unpublic') && !empty($issueCert)){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'8'));
					$this->db->where($issueCert);
				}
				if(!empty($type=='unpubrej') && !empty($issueRej)){
					$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'11'));
					$this->db->where($issueRej);
				}
				if($type != 'unpublic' && $type != 'unpub_objection' && $type != 'unpubrej'){
					$this->db->where($cndtn);
				}				
				// $result= $this->db->where_in()->order_by('labour_factorybuilding_plan.id','ASC')->order_by('modified_date')->get()->result_array();							
				$result= $this->db->get()->result_array();							
				
				return $result;
			}
		}
		// public function getapplications($type,$limit,$offset){
		// 	$dept_officer			=	$_SESSION['department'];
		// 	$app_divider			=	"";
		// 	$cndtn				=	"";
		// 	if(isset($dept_officer['app_divider'][12])){
		// 		$app_divider 		=	str_replace('-','',$dept_officer['app_divider'][12]);
		// 		$cndtn				=	"factory_registrations.app_divider IN ($app_divider)";
		// 		$appdiv				=		explode(",",$app_divider);
		// 	}
		// 	if(isset($dept_officer['privileges'][12])){
		// 		$admin_privileges 		=	explode(",",str_replace("-","",$dept_officer['privileges'][12]));				
		// 	}
		
		// 	// permission - issue certificate for dlcc not eec (fetch unpublished license appln of only dlcc)
		// 	$issueCert 			=	"";
		// 	if(in_array(112,$admin_privileges) && in_array(2,$appdiv)){
		// 		$issueCert		=	" factory_registrations.app_divider = 2";
		// 	}
		// 	elseif(!in_array(112,$admin_privileges)){
		// 		$issueCert		=	" factory_registrations.app_divider IN ($app_divider)";
		// 	}
		
		// 	// permission - issue objection for dlcc not eec (fetch unpublished observation appln of only dlcc)
		// 	$issueObj 			=	"";
		// 	if(in_array(133,$admin_privileges) && in_array(2,$appdiv)){
		// 		$issueObj		=	" factory_registrations.app_divider = 2";
		// 	}
		// 	elseif(!in_array(133,$admin_privileges)){
		// 		$issueObj		=	" factory_registrations.app_divider IN ($app_divider)";
		// 	}
		
		// 	// permission - issue rejection for dlcc not eec (fetch unpublished rejection appln of only dlcc)
		// 	$issueRej 			=	"";
		// 	if(in_array(147,$admin_privileges) && in_array(2,$appdiv)){
		// 		$issueRej		=	" factory_registrations.app_divider = 2";
		// 	}
		// 	elseif(!in_array(147,$admin_privileges)){
		// 		$issueRej		=	" factory_registrations.app_divider IN ($app_divider)";
		// 	}
		
		
		// 	if(!empty($type == 'unassigned'))
		// 	{
		// 		$this->db->limit($limit, $offset);
		// 		$this->db->where('assigned_to','18888888');				
		// 		$result = $this->db->select('*')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->get()->result_array();
		// 		return $result;
		// 	}
		// 	if(!empty($type=='hepc')){
		// 		@$this->db->select('labour_factorybuilding_plan.*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id');
		// 		$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>1));
		// 		$this->db->group_start();
		// 		$this->db->where("factory_registrations.factory_reg_director_circle",NULL);
		// 		$this->db->or_where("factory_registrations.factory_reg_director_circle",0);			
		// 		$this->db->group_end();				
		// 		$this->db->where('factory_registrations.projectid != ','');
		// 		$result=$this->db->group_by('labour_factorybuilding_plan.id')->get()->result_array();
		
		// 		return $result;	
		// 	}
		// 	if(!empty($type == 'assigned')){	
		// 		$this->db->limit($limit, $offset);
		// 		$job_id = $this->session->userdata['department']['job_id'];
		// 		$query = $this->db->select('labour_factorybuilding_decisions.*,labour_factorybuilding_plan.id')->from('labour_factorybuilding_decisions')->JOIN('labour_factorybuilding_plan','labour_factorybuilding_decisions.complaint_id = labour_factorybuilding_plan.id')->like('assigned_to',$job_id)->where('labour_factorybuilding_plan.status',1)->where('labour_factorybuilding_plan.final_status',3)->order_by('labour_factorybuilding_plan.id','ASC')->get()->result_array();				
		// 		if(empty($query)) {
		// 			return false;
		// 		}
		// 		$complaint_id = array();
		// 		foreach($query as $que){
		// 			$complaint_id[]= $que['complaint_id'];
		// 		}
		// 		$complaint_ids = implode(',',$complaint_id);
		// 		$result = $this->db->select('*')->from('labour_factorybuilding_plan')->where_in('labour_factorybuilding_plan.id',$complaint_ids,false)->get()->result_array();					
		// 		return $result;
		// 	}
		
		// 	if(!empty($cndtn)){
		// 		$distt = $this->getjuristrictions();							
		// 		$this->db->limit($limit, $offset);
		// 		if(!empty($type == 'newtab')){
		// 			$this->db->order_by('labour_factorybuilding_plan.modified_date');
		// 			$where 	=	"labour_factorybuilding_plan.final_status NOT IN (2,5,10,0) AND labour_factorybuilding_plan.status = 1";
		// 			return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where($where)->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where_in('factory_registrations.app_divider',array(1,2))->get()->result_array();
		// 		} 	
		// 		if(!empty($type =='new')){					
		// 			return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->where(array('labour_factorybuilding_plan.final_status'=>1,'labour_factorybuilding_plan.status'=>1))->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where($cndtn)->get()->result_array();
		// 		}
		
		// 		if(!empty($type=='process')){
		// 			return $this->db->select('*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where(array('labour_factorybuilding_plan.final_status'=>3,'labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_decisions.assigned_to'=>''))->where($cndtn)->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->get()->result_array();
		// 		}
		// 		if(!empty($issueObj) && !empty($issueCert)){
		// 			@$this->db->select('labour_factorybuilding_plan.*')->from('labour_factorybuilding_plan')->JOIN('factory_registrations','labour_factorybuilding_plan.factory_reg_id = factory_registrations.factory_reg_id')->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id')->where_in('factory_registrations.factory_reg_director_circle',str_replace('-','',$distt),false)->where($cndtn);
		// 		}
		// 		else{
		// 			return 0;
		// 		}
		// 		if(!empty($type=='reject')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'5'));
		// 		}
		// 		if(!empty($type=='close')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'2'));
		// 		}
		// 		if(!empty($type=='objection')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'4'));
		// 		}
		// 		if(!empty($type=='reply')){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'6'));
		// 		}
		// 		if(!empty($type=='unpub_objection') && !empty($issueObj)){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'7'));
		// 			$this->db->where($issueObj);
		// 		}
		// 		if(!empty($type=='unpubrej') && !empty($issueRej)){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'11'));
		// 			$this->db->where($issueRej);
		// 		}
		// 		if(!empty($type=='unpublic') && !empty($issueCert)){
		// 			$this->db->where(array('labour_factorybuilding_plan.status'=>1,'labour_factorybuilding_plan.final_status'=>'8'));
		// 			$this->db->where($issueCert);
		// 		}
		// 		if($type != 'unpublic' && $type != 'unpub_objection' && $type != 'unpubrej'){
		// 			$this->db->where($cndtn);
		// 		}
		// 		$result= $this->db->where_in()->order_by('labour_factorybuilding_plan.id','ASC')->get()->result_array();			
		
		// 		return $result;
		// 	}
		// }
		
		
		
		
		
		/*
			*	AddedDate: 21st march 2016
			*	AddedBy: samriti
			*	FunctionName: viewcomplaint
			*	Purpose: View complaint detail
		*/
		public function viewapplication($id){
			//$distt = $this->getjuristrictions();
			//print_r($distt);die;
			$this->db->where("id",$id);  
			$this->db->select("*");
			$query = $this->db->from("labour_factorybuilding_plan")->get();
			return $query->row_array();
			
			//echo $this->db->last_query();die;
			
		}
		public function getArchitect($id){
			
			$this->db->where("plan_id",$id); 
			$this->db->from("labour_factorybuilding_form1b as form1b");	
			$this->db->join("labour_factorybuilding_architects as architect", 'form1b.architect_id = architect.id');			
			$this->db->select("architect.architect_name, architect.architect_qualification, architect.architect_present_occupation, architect. architect_postal_address");
			$query = $this->db->get();
			
			return $query->row_array();
			
			
		}
		/*
			*	AddedDate: 21st march 2016
			*	AddedBy: samriti
			*	FunctionName: getpermissions
			*	Purpose: get the permissions assigned to the job
		*/
		public function getpermissions(){
			$job_id = $this->session->userdata['department']['job_id'];
			
			$types = explode(',',str_replace('-','',$this->session->userdata['department']['job_type']));
			
			if(in_array('12',$types)) {
				$privileges = $this->db->select("privileges")->from("labour_admin_job_detail")->where(array('job_id'=>$job_id,'job_type'=>'12'))->get()->row_array();
				if(!is_null($privileges) && !empty($privileges)){
					return $this->db->select('*')->from('labour_privilege_type')->where_in('id',str_replace('-','',$privileges['privileges']),false)->get()->result_array();
				}
			}
			return "";
		}
		/*
			*	AddedDate: 21st march 2016
			*	AddedBy: samriti
			*	FunctionName: updatecomplaintstatus
			*	Purpose: update the record after the department officer has uploaded report
		*/
		public function insertcomplaintstatus($insertdata){
			$exists = $this->db->select("*")->from("labour_factorybuilding_decisions")->where('complaint_id',$insertdata['complaint_id'])->get()->row_array();	
			//pr($exists);die;
			if(empty($exists)) {
				$this->db->insert('labour_factorybuilding_decisions',$insertdata);
			} 
			else {
				$this->db->update('labour_factorybuilding_decisions',$insertdata,array('complaint_id'=>$insertdata['complaint_id']));
				unset($exists['id']);
				$this->db->insert('labour_factorybuilding_subdecision',$exists);
			}
			//echo $this->db->last_query();die;
			return $this->db->insert_id();
		}
		public function getdocumenthistory($complaint_id){
			$query = $this->db->select('labour_factorybuilding_subdecision.*,labour_privilege_type.privilege_name as status,labour_factorybuilding_subdecision.status as jdstatus')->from('labour_factorybuilding_subdecision')->JOIN('labour_privilege_type', 'labour_factorybuilding_subdecision.status = labour_privilege_type.id')->where('complaint_id',$complaint_id)->get();
			//echo $this->db->last_query();die;
			return $query->result_array();
		}
		public function getdocumentlatest($complaint_id){
			$query = $this->db->select('labour_factorybuilding_decisions.*,labour_privilege_type.privilege_name as status,labour_factorybuilding_decisions.status as jdstatus')->from('labour_factorybuilding_decisions')->JOIN('labour_privilege_type', 'labour_factorybuilding_decisions.status = labour_privilege_type.id')->where('complaint_id',$complaint_id)->get();
			//echo $this->db->last_query();die;
			return $query->result_array();
		}
		public function allgetcomplainttypes(){
			
			$qry = $this->db->select('*')->from('complaint_types')->get();
			return $qry->result_array();
		}
		public function getDistData(){
			$query = $this->db->query("SELECT * FROM labour_distt WHERE states_id = 1");
			return $query->result_array();			
		}	
		public function getstatus(){
			$qry = $this->db->select('*');
			$this->db->from('labour_privilege_type');
			$this->db->where('privilege_id','7');
			$qry = $this->db->get();			
			return $qry->result_array();
		}
		
		/* public function getdepartmentofficers($circle,$app_divider){
			$distt = $this->getjuristrictions();	
			$qry = $this->db->select("*")->from('labour_admin_job_detail as detail');
			$this->db->where("detail.job_id <>",$_SESSION['department']['job_id']);
			$this->db->where('detail.job_type','12');
			$this->db->like("detail.director_area_id",'-'.$circle.'-',FALSE);			
			$this->db->like("detail.app_divider","-".$app_divider."-");
			$this->db->where("job.status",1);
			$this->db->join("labour_admin_job as job","job.id = detail.job_id");
			$jobs = $this->db->get()->result_array();											
			return $jobs;			
		} */
		
		public function getdepartmentofficers($planid){
			$result = 	$this->db->select('step1_officer,step2_officer,step3_officer,step4_officer,step6_officer')->from('labour_factorybuilding_plan')->where('id',$planid)->get()->row_array();
			
			if($_SESSION['department']['job_id'] == 157){
				$step2officers 	=	$this->db->select('job_id')->where('job_type',12)->where('fbp_officers',1)->from('labour_admin_job_detail')->get()->result_array();
				foreach($step2officers as $step2){
					$step2arr[] 	=	$step2['job_id'];
				}
				$array1	=	array($result['step2_officer'],$result['step3_officer'],$result['step4_officer'],$result['step6_officer']);
				$array 	=	array_merge($array1,$step2arr);
			}
			else{			
				$array	=	array($result['step1_officer'],$result['step2_officer'],$result['step3_officer'],$result['step4_officer'],$result['step6_officer']);
			}
			
			//$array	=	array($result['step1_officer'],$result['step2_officer'],$result['step3_officer'],$result['step4_officer']);
			return $array;
		}
		
		//  Get building plan detail
		public function getPlandetail($plan_id) {
			return $this->db->select('*')->from('labour_factorybuilding_plan')->where(array('id'=>$plan_id))->get()->result_array();
		}
		
		//  Get Factory Details  
		public function getFactoryDetail($factory_id) {
			//$factory_info = $this->db->select('*')->from('factory_registrations')->where(array('factory_reg_id'=>$factory_id))->get()->row_array();
			
			$qry="SELECT main. * , u. distt_name, test.tehsil_name, vil . villages_name,indre.industrial_region,indst.industrial_state
			FROM factory_registrations AS main
			LEFT JOIN  labour_distt AS u ON main.factory_reg_u_district = u.distt_id
			LEFT JOIN  labour_tehsil AS test ON main.factory_reg_u_tehsil = test.tehsil_id
			LEFT JOIN  labour_villages AS vil ON main.factory_reg_u_village = vil.villages_id
			LEFT JOIN  labour_industrial_region AS indre ON main.factory_reg_u_indust = indre.industrial_regionid
			LEFT JOIN labour_industrial_states AS indst ON main.factory_reg_u_region = indst.industrial_state_id
			WHERE main.factory_reg_id = '".$factory_id."'";
			$factory_info = $this->db->query($qry)->result_array();
			return $factory_info[0];
		}
		
		//  Get all building plan detail
		public function getArchitects() {
			return $this->db->select('*')->from('labour_factorybuilding_architects')->where(array('status'=>1))->get()->result_array();
		}
		
		//  Get all building plan detail
		public function getPlan_form1b($plan_id) {
			return $this->db->select('*')->from('labour_factorybuilding_form1b')->where(array('plan_id'=>$plan_id))->order_by('id','DESC')->get()->result_array();
		}
		
		//  Get all building plan detail
		public function getPlan_form1($plan_id) {
			return $this->db->select('*')->from('labour_factorybuilding_form1')->where(array('plan_id'=>$plan_id))->get()->result_array();
		}
		
		//  Get all building plan detail
		public function getofficername($id) {
			$name= $this->db->select('*')->from('labour_admin')->where(array('admin_id'=>$id))->get()->row_array();
			return $name['admin_name']." (".$name['admin_post'].")";
		}
		
		/**
			*	AddedDate: 2 May 2016;
			*	AddedBy: harjot
			*	FunctionName:  countObjections
			*	Purpose: Update factory director circle and AD officer
		**/
		public function countObjections($plan_id){
			$this->db->where("plan_id",$plan_id);
			$this->db->where("obj_status",'0');
			$query = $this->db->from("labour_factorybuilding_objection")->get();
			//$this->db->last_query();die;
			return $query->result_array();
			
		}
		
		
		/*			
			AddedDate: 3 May 2016
			AddedBy: harjot
			FunctionName: getPrivileges
			Purpose: Fetch deptt officer's privileges on the basis of privilege id
		*/
		public function getPrivileges($id, $job_id){
			$this->db->where_in("id",$id);			
			$query = $this->db->from("labour_privilege_type")->get();			
			return $query->result_array();
		}
		/*
			*	AddedDate: 18 Jan 2016;
			*	AddedBy: Mohinder
			*	FunctionName:  getOfficerByID
			*	Purpose: Get Single  Officer
		*/                
		public function getOfficerByID($officer_id) {
			$qry = $this->db->select('*,(SELECT `title` FROM `labour_admin_job` WHERE `id`=labour_admin.job_id) job_title')->from('labour_admin')->where(array('admin_id'=>$officer_id))->get();        
			return $qry->row_array();
		}
		
		/*			
			AddedDate: 21 April 2016
			AddedBy: Sonia
			FunctionName: addObjection
			Purpose: Add Objection record 
		*/
		public function addObjection($data){		
			$check_status	=	$this->db->select('*')->from('labour_factorybuilding_plan')->where('id',$data['plan_id'])->get()->row_array()['final_status'];
			if($check_status	==	4)
			{
				$status_array	=	array('final_status'=>'7');
				$this->db->where('id', $data['plan_id']);
				$this->db->update('labour_factorybuilding_plan',$status_array);
			}				
			$this->db->insert("labour_factorybuilding_objection",$data);
			return $this->db->insert_id();
		}
		public function update_status_licence($status_array,$planid){
			$this->db->where('id', $planid);
			return $this->db->update('labour_factorybuilding_plan',$status_array);
		}
		/*			
			AddedDate: 21 April 2016
			AddedBy: Sonia
			FunctionName: editObjection
			Purpose: Edit Objection record 
		*/
		public function editObjection($data,$id){
			$this->db->where("obj_id",$id);
			$this->db->update("labour_factorybuilding_objection",$data);
			return true;
		}
		/*			
			AddedDate: 20 April 2016
			AddedBy: Sonia
			FunctionName: getLatestObjection
			Purpose: Get latest objection by license ID
		*/
		public function getLatestObjection($id){
			$sql = "SELECT MAX(obj_id) as id FROM labour_factorybuilding_objection WHERE plan_id = '".$id."' ";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		
		/*			
			AddedDate: 28 April 2016
			AddedBy: Sonia
			FunctionName: getObjectionById
			Purpose: Get objection by Id
		*/
		public function getObjectionById($id){
			$this->db->where("obj_id",$id);
			$query = $this->db->from("labour_factorybuilding_objection")->get();
			return $query->row_array();
		}
		/*			
			AddedDate: 25 April 2016
			AddedBy: Sonia
			FunctionName: getObjection
			Purpose: Fetch Objections on a license application
		*/
		public function getObjection($licId){
			/* $this->db->where("plan_id",$licId);
				$this->db->where("obj_status","1");
				$this->db->order_by("obj_created","ASC");
				$query = $this->db->from("labour_factorybuilding_objection")->get();
			return $query->result_array(); */
			$this->db->order_by("obj_id", "DESC");
			$infos = $this->db->select('*')->from("labour_factorybuilding_objection")->where(array('obj_status'=>'1','plan_id'=>$licId))->get()->result_array();     
			$result = array();
			foreach($infos as $info) {
				$info['reply'] = $this->db->select('*')->from('labour_factorybuilding_objection_reply')->where('rep_obj_id',$info['obj_id'])->get()->result_array();
				$result[] = $info;
			}
			return $result;
		}
		
		/*			
			AddedDate: 25 April 2016
			AddedBy: Sonia
			FunctionName: getObjReplyCount
			Purpose: Fetch objection reply count
		*/
		public function getObjReplyCount($licId,$obj_id = NULL){
			if($obj_id != NULL)
			$this->db->where("rep_obj_id",$obj_id);
			else
			$this->db->where("rep_obj_id !=","");
			
			if($licId != 0)
			$this->db->where("rep_plan_id",$licId);
			
			$query = $this->db->from("labour_factorybuilding_objection_reply")->get();
			
			return $query->num_rows();
		}
		
		/*			
			AddedDate: 25 April 2016
			AddedBy: Sonia
			FunctionName: getObjReplyCount
			Purpose: Fetch objection reply count
		*/
		public function viewReplyObservation($obj_id = NULL){
			if($obj_id != NULL)
			$this->db->where("rep_id",$obj_id);
			
			$query = $this->db->from("labour_factorybuilding_objection_reply")->get();
			
			return $query->result_array();
		}
		
		/*			
			AddedDate: 5 May 2016
			AddedBy: Harjot
			FunctionName: getcurrent status
			Purpose: Fetch status of application
		*/
		public function getlateststatus($pid){
			$name= $this->db->select('status')->from('labour_factorybuilding_decisions')->where(array('complaint_id'=>$pid))->get()->row_array();
			return $name['status'];
		}
		
		/*
			*	AddedDate: 20-09-2016
			*	AddedBy: harjot
			*	FunctionName: getTotalmisdata
			*	Purpose: get total building plan apps
		*/
		public function getTotalmisdata($srch){
			
			$job_id = $this->session->userdata['department']['job_id'];				
			if(!empty($limit))
			$this->db->limit($limit, $offset);
			$this->db->select('labour_factorybuilding_plan.*,count(*) total,reg.app_divider')->from('labour_factorybuilding_plan')->join("factory_registrations as reg","reg.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
			
			if( ($srch['app_divider'] != '')){		
				$this->db->where('reg.app_divider',$srch['app_divider']);
			}
			
			if( ($srch['status'] != '')){
				if($srch['status'] == 8){
					if(empty($srch['sdate']) && empty($srch['edate'])){
						$this->db->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
					}
					$this->db->where('labour_factorybuilding_decisions.status',34);
				}
				else{
					$this->db->where('labour_factorybuilding_plan.final_status',$srch['status']);
				}
				//$this->db->where('labour_factorybuilding_plan.final_status',$srch['status']);
			}
			else{
				$this->db->where('labour_factorybuilding_plan.final_status > 0');
				$this->db->where('reg.defunc_status != 3');
			}
			if( (!empty($srch['distt_id'])) && $srch['distt_id']!='') {
				$this->db->where('reg.factory_reg_u_district',$srch['distt_id']);		
			}			
			
			if(!empty($srch['sdate']) && !empty($srch['edate'])) 
			{
				if($srch['status'] == 10)
				{
					$this->db->JOIN('labour_factorybuilding_rejection', 'labour_factorybuilding_plan.id = labour_factorybuilding_rejection.plan_id');
					$where = "date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))<='".$srch['edate']."'";	
					$this->db->where($where);		
				}
				elseif($srch['status'] == 2)
				{
					$this->db->JOIN('labour_factorybuilding_plan_cert','labour_factorybuilding_plan.id = labour_factorybuilding_plan_cert.complaint_id');
					$where = "date(`labour_factorybuilding_plan_cert`.`date_published`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan_cert`.`date_published`)<='".$srch['edate']."'";	
					$this->db->where($where);	
				}
				elseif($srch['status'] == 1 || $srch['status'] == 3 || $srch['status'] == 4 || $srch['status'] == 5 || $srch['status'] == 6 || $srch['status'] == 7 || $srch['status'] == 8 || $srch['status'] == 9 || $srch['status'] == 11)
				{
					$this->db->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
					$where = "date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."'";	
					$this->db->where($where);	
				}
				else
				{
					$where = "date(`labour_factorybuilding_plan`.`created_date`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan`.`created_date`)<='".$srch['edate']."'";	
					$this->db->where($where);		
				}
			}
			
			if(!empty($srch['keyword'])) {			 	
				if(is_numeric($srch['keyword'])){
					//echo "1";
					$this->db->join("factory_registrations as reg_f","reg_f.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
					$this->db->where('labour_factorybuilding_plan.factory_reg_id',$srch['keyword']);
					$this->db->or_where('labour_factorybuilding_plan.id',$srch['keyword']);
					$this->db->or_where('reg_f.cafpin',$srch['keyword']);
				}
				else{
					//echo "2";
					$like = "(labour_factorybuilding_plan.plant LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR labour_factorybuilding_plan.factory_name LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR  `labour_factorybuilding_plan`.`factory_address` LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%') ";
					$this->db->where($like);
				}	
			}
			
			if($srch['keyword_app_id']!="") {
				if(is_numeric(trim($srch['keyword_app_id']))) {
					$this->db->where('labour_factorybuilding_plan.id',$srch['keyword_app_id']);
				}
				} else {
				$this->db->join('(SELECT max(id) id FROM labour_factorybuilding_plan GROUP BY factory_reg_id) app2','labour_factorybuilding_plan.id = app2.id','inner');
			}
			
			$result= $this->db->where_in()->order_by('labour_factorybuilding_plan.id','ASC')->get()->row_array()['total'];		
			/* if($_SESSION['department']['job_id'] == 675){
				echo $this->db->last_query(); 
			} */
			return $result;
		}
		public function getTotalmisdata_testing($srch){
			
			$job_id = $this->session->userdata['department']['job_id'];				
			if(!empty($limit))
			$this->db->limit($limit, $offset);
			$this->db->select('labour_factorybuilding_plan.*,count(*) total,reg.app_divider')->from('labour_factorybuilding_plan')->join("factory_registrations as reg","reg.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
			
			if( ($srch['app_divider'] != '')){		
				$this->db->where('reg.app_divider',$srch['app_divider']);
			}
			
			if( ($srch['status'] != '')){		
				if($srch['status'] == 8){	
					$this->db->where_in('labour_factorybuilding_plan.final_status',[2,8]);
					}else{
					$this->db->where('labour_factorybuilding_plan.final_status',$srch['status']);
				}
			}
			else{
				$this->db->where('labour_factorybuilding_plan.final_status > 0');
				$this->db->where('reg.defunc_status != 3');
			}
			if( (!empty($srch['distt_id'])) && $srch['distt_id']!='') {
				$this->db->where('reg.factory_reg_u_district',$srch['distt_id']);		
			}			
			
			if(!empty($srch['sdate']) && !empty($srch['edate'])) 
			{
				if($srch['list_type']=='bip_wise') {
					if($srch['status'] == 10) {
						$this->db->JOIN('labour_factorybuilding_rejection', 'labour_factorybuilding_plan.id = labour_factorybuilding_rejection.plan_id');
						$where = "date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))<='".$srch['edate']."'";	
						$this->db->where($where);		
					}
					elseif($srch['status'] == 2)
					{
						$this->db->JOIN('labour_factorybuilding_plan_cert','labour_factorybuilding_plan.id = labour_factorybuilding_plan_cert.complaint_id');
						$where = "date(`labour_factorybuilding_plan_cert`.`date_published`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan_cert`.`date_published`)<='".$srch['edate']."'";	
						$this->db->where($where);	
					}
					else if($srch['status'] == 1 || $srch['status'] == 3 || $srch['status'] == 4 || $srch['status'] == 5 || $srch['status'] == 6 || $srch['status'] == 7 || $srch['status'] == 8 || $srch['status'] == 9 || $srch['status'] == 11) {
						$this->db->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
						$where = "date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."'";	
						$this->db->where($where);	
						} else {
						$where = "date(`labour_factorybuilding_plan`.`created_date`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan`.`created_date`)<='".$srch['edate']."'";	
						$this->db->where($where);		
					}
				}
				else{
					if($srch['date_type']=='submission') {
						$where = "date(`labour_factorybuilding_plan`.`created_date`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan`.`created_date`)<='".$srch['edate']."'";	
						$this->db->where($where);
					}
					else{
						if($srch['status'] == 10) {
							$this->db->JOIN('labour_factorybuilding_rejection', 'labour_factorybuilding_plan.id = labour_factorybuilding_rejection.plan_id');
							$where = "date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))<='".$srch['edate']."'";	
							$this->db->where($where);		
						}
						elseif($srch['status'] == 2)
						{
							$this->db->JOIN('labour_factorybuilding_plan_cert','labour_factorybuilding_plan.id = labour_factorybuilding_plan_cert.complaint_id');
							$where = "date(`labour_factorybuilding_plan_cert`.`date_published`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan_cert`.`date_published`)<='".$srch['edate']."'";	
							$this->db->where($where);	
							$this->db->join('(SELECT max(id) id FROM labour_factorybuilding_plan_cert GROUP BY complaint_id) app2','labour_factorybuilding_plan_cert.id = app2.id','inner');
						}
						else {
							$this->db->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
							$where = "date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."'";	
							$this->db->where($where);	
						}
					}
				}
			}
			
			if(!empty($srch['keyword'])) {			 	
				if(is_numeric($srch['keyword'])){
					//echo "1";
					$this->db->join("factory_registrations as reg_f","reg_f.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
					$this->db->group_start();
					$this->db->where('labour_factorybuilding_plan.factory_reg_id',$srch['keyword']);
					$this->db->or_where('labour_factorybuilding_plan.id',$srch['keyword']);
					$this->db->or_where('reg_f.cafpin',$srch['keyword']);
					$this->db->group_end();
				}
				else{
					//echo "2";
					$like = "(labour_factorybuilding_plan.plant LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR labour_factorybuilding_plan.factory_name LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR  `labour_factorybuilding_plan`.`factory_address` LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%') ";
					$this->db->where($like);
				}	
			}
			if($srch['list_type']=='bip_wise') {	
				if($srch['keyword_app_id']!="") {
					if(is_numeric(trim($srch['keyword_app_id']))) {
						$this->db->where('labour_factorybuilding_plan.id',$srch['keyword_app_id']);
					}
					} else {
					$this->db->join('(SELECT max(id) id FROM labour_factorybuilding_plan GROUP BY factory_reg_id) app2','labour_factorybuilding_plan.id = app2.id','inner');
				}
			}
			
			$result= $this->db->where_in()->order_by('labour_factorybuilding_plan.id','ASC')->get()->row_array()['total'];						
			return $result;
		}
		/*
			*	AddedDate: 20-09-2016
			*	AddedBy: harjot
			*	FunctionName:getDocumentsbycategoryid
			*	Purpose: laws listing with the search keywords
		*/
		public function getmisdatasearcheddata($srch = NULL,$limit = NULL,$offset=0){
			//pr($category_id);die;
			$job_id = $this->session->userdata['department']['job_id'];				
			if(!empty($limit))
			$this->slaveDB->limit($limit, $offset);
			
			$this->slaveDB->select('labour_factorybuilding_plan.*,reg.app_divider,reg.factory_reg_u_mobile, reg.factory_reg_u_email, reg.cafpin')->from('labour_factorybuilding_plan')->join("factory_registrations as reg","reg.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
			//->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
			
			if( ($srch['app_divider'] != '')){		
				$this->slaveDB->where('reg.app_divider',$srch['app_divider']);
			}
			
			if( ($srch['status'] != '')){
				if($srch['status'] == 8){
					if(empty($srch['sdate']) && empty($srch['edate'])){
						$this->slaveDB->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
					}
					$this->slaveDB->where('labour_factorybuilding_decisions.status',34);
				}
				else{
					$this->slaveDB->where('labour_factorybuilding_plan.final_status',$srch['status']);
				}
			}
			else{
				$this->slaveDB->where('labour_factorybuilding_plan.final_status > 0');
				$this->slaveDB->where('reg.defunc_status != 3');
			}
			
			if( (!empty($srch['distt_id'])) && $srch['distt_id']!='') {
				$this->slaveDB->where('reg.factory_reg_u_district',$srch['distt_id']);		
			}			
			
			if(!empty($srch['sdate']) && !empty($srch['edate'])) 
			{
				if($srch['status'] == 10)
				{
					$this->slaveDB->JOIN('labour_factorybuilding_rejection', 'labour_factorybuilding_plan.id = labour_factorybuilding_rejection.plan_id');
					$where = "date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))<='".$srch['edate']."'";	
					$this->slaveDB->where($where);	
				}
				elseif($srch['status'] == 2)
				{
					$this->slaveDB->JOIN('labour_factorybuilding_plan_cert','labour_factorybuilding_plan.id = labour_factorybuilding_plan_cert.complaint_id');
					$where = "date(`labour_factorybuilding_plan_cert`.`date_published`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan_cert`.`date_published`)<='".$srch['edate']."'";	
					$this->slaveDB->where($where);	
				}
				elseif($srch['status'] == 3 || $srch['status'] == 4 || $srch['status'] == 5 || $srch['status'] == 6 || $srch['status'] == 7 || $srch['status'] == 8 || $srch['status'] == 9 || $srch['status'] == 11) //$srch['status'] == 2 || 
				{
					$this->slaveDB->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
					$where = "date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."'";	 
					$this->slaveDB->where($where);	
				}
				else
				{
					$where = "date(`labour_factorybuilding_plan`.`created_date`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan`.`created_date`)<='".$srch['edate']."'";	
					$this->slaveDB->where($where);		
				}
			}
			
			
			if(!empty($srch['keyword'])) {				
				if(is_numeric($srch['keyword'])){
					$this->slaveDB->join("factory_registrations as reg_f","reg_f.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
					$this->slaveDB->where('labour_factorybuilding_plan.factory_reg_id',$srch['keyword']);
					$this->slaveDB->or_where('labour_factorybuilding_plan.id',$srch['keyword']);
					$this->slaveDB->or_where('reg_f.cafpin',$srch['keyword']);
				}
				else{
					$like = "(labour_factorybuilding_plan.plant LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR labour_factorybuilding_plan.factory_name LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR  `labour_factorybuilding_plan`.`factory_address` LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%') ";
					$this->slaveDB->where($like);
				}	
			}
			
			if($srch['keyword_app_id']!="") {
				if(is_numeric(trim($srch['keyword_app_id']))) {
					$this->slaveDB->where('labour_factorybuilding_plan.id',$srch['keyword_app_id']);
				}
				} else {
				$this->slaveDB->join('(SELECT max(id) id FROM labour_factorybuilding_plan GROUP BY factory_reg_id) app2','labour_factorybuilding_plan.id = app2.id','inner');
			}
			
			$result= $this->slaveDB->where_in()->order_by('labour_factorybuilding_plan.id','ASC')->get()->result_array();						
			/* if($_SESSION['department']['job_id'] == 675){
				echo $this->slaveDB->last_query(); 
			} */
			
			return $result;
			
		}
		
		public function getmisdatasearcheddata_testing($srch = NULL,$limit = NULL,$offset=0){
			
			//pr($category_id);die;
			$job_id = $this->session->userdata['department']['job_id'];				
			if(!empty($limit))
			$this->slaveDB->limit($limit, $offset);
			
			$this->slaveDB->select('labour_factorybuilding_plan.*,reg.app_divider,reg.factory_reg_u_mobile, reg.factory_reg_u_email, reg.cafpin')->from('labour_factorybuilding_plan')->join("factory_registrations as reg","reg.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
			//->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
			
			if( ($srch['app_divider'] != '')){		
				$this->slaveDB->where('reg.app_divider',$srch['app_divider']);
			}
			$this->slaveDB->where('reg.defunc_status != 3');
			
			if( ($srch['status'] != '')){	
				if($srch['status'] == 11){	
					$this->slaveDB->where_in('labour_factorybuilding_plan.final_status',[11,10]);
				} else if($srch['status'] == 8){	
					$this->slaveDB->where_in('labour_factorybuilding_plan.final_status',[2,8]);
				}else if($srch['status'] == 3){	
					$this->slaveDB->where_in('labour_factorybuilding_plan.final_status',[3,6]);
				}else{
					$this->slaveDB->where('labour_factorybuilding_plan.final_status',$srch['status']);
				}
			}
			else{
				$this->slaveDB->where('labour_factorybuilding_plan.final_status > 0');
				
			}
			
			if( (!empty($srch['distt_id'])) && $srch['distt_id']!='') {
				$this->slaveDB->where('reg.factory_reg_u_district',$srch['distt_id']);		
			}			
			
			if(!empty($srch['sdate']) && !empty($srch['edate'])) 
			{
				if($srch['list_type']=='bip_wise') {
					if($srch['status'] == 10) {
						$this->slaveDB->JOIN('labour_factorybuilding_rejection', 'labour_factorybuilding_plan.id = labour_factorybuilding_rejection.plan_id');
						$where = "date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))<='".$srch['edate']."'";	
						$this->slaveDB->where($where);	
					} 
					elseif($srch['status'] == 2)
					{
						$this->slaveDB->JOIN('labour_factorybuilding_plan_cert','labour_factorybuilding_plan.id = labour_factorybuilding_plan_cert.complaint_id');
						$where = "date(`labour_factorybuilding_plan_cert`.`date_published`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan_cert`.`date_published`)<='".$srch['edate']."'";	
						$this->slaveDB->where($where);	
					}
					else if($srch['status'] == 3 || $srch['status'] == 4 || $srch['status'] == 5 || $srch['status'] == 6 || $srch['status'] == 7 || $srch['status'] == 8 || $srch['status'] == 9 || $srch['status'] == 11) {
						$this->slaveDB->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
						$where = "date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."'";	
						$this->slaveDB->where($where);	
						} else {
						$where = "date(`labour_factorybuilding_plan`.`created_date`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan`.`created_date`)<='".$srch['edate']."'";	
						$this->slaveDB->where($where);		
					}
				}
				else{
					if($srch['date_type']=='submission') {
						$where = "date(`labour_factorybuilding_plan`.`created_date`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan`.`created_date`)<='".$srch['edate']."'";	
						$this->slaveDB->where($where);	
					}
					else{
						if($srch['status']==""){
							$this->slaveDB->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id','left');
							$where_dec = "(labour_factorybuilding_decisions.modified IS NOT NULL AND date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."' AND labour_factorybuilding_plan.final_status not in (2,10))";	
							
							$cert_subquery = "(SELECT * FROM labour_factorybuilding_plan_cert WHERE labour_factorybuilding_plan_cert.id IN (SELECT MAX(labour_factorybuilding_plan_cert.id) FROM labour_factorybuilding_plan_cert GROUP BY complaint_id)) cert";
							$this->slaveDB->join($cert_subquery, 'cert.complaint_id = labour_factorybuilding_plan.id', 'left', FALSE);
							$where_pub = "(cert.date_published IS NOT NULL AND date(`cert`.`date_published`)>='".$srch['sdate']."' AND date(`cert`.`date_published`)<='".$srch['edate']."' AND labour_factorybuilding_plan.final_status=2)";	
							
							$reject_subquery = "(SELECT * FROM labour_factorybuilding_rejection WHERE rej_id IN (SELECT MAX(rej_id) FROM labour_factorybuilding_rejection GROUP BY plan_id)) reject";
							$this->slaveDB->join($reject_subquery, 'reject.plan_id = labour_factorybuilding_plan.id', 'left', FALSE);
							$where_rej = "(reject.rej_created IS NOT NULL AND date(FROM_UNIXTIME(`reject`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`reject`.`rej_created`))<='".$srch['edate']."' AND labour_factorybuilding_plan.final_status=10)";	
							
							$where = "(".$where_dec." OR ".$where_pub." OR ".$where_rej.")";
							$this->slaveDB->where($where);
						}else{
							if($srch['status'] == 10) {
								$this->slaveDB->JOIN('labour_factorybuilding_rejection', 'labour_factorybuilding_plan.id = labour_factorybuilding_rejection.plan_id');
								$where = "date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))>='".$srch['sdate']."' AND date(FROM_UNIXTIME(`labour_factorybuilding_rejection`.`rej_created`))<='".$srch['edate']."'";	
								$this->slaveDB->where($where);	
							}
							elseif($srch['status'] == 2) {
								$this->slaveDB->JOIN('labour_factorybuilding_plan_cert','labour_factorybuilding_plan.id = labour_factorybuilding_plan_cert.complaint_id');
								$where = "date(`labour_factorybuilding_plan_cert`.`date_published`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_plan_cert`.`date_published`)<='".$srch['edate']."'";	
								$this->slaveDB->where($where);	
								$this->slaveDB->join('(SELECT max(id) id FROM labour_factorybuilding_plan_cert GROUP BY complaint_id) app2','labour_factorybuilding_plan_cert.id = app2.id','inner');							
							}
							else {
								$this->slaveDB->JOIN('labour_factorybuilding_decisions','labour_factorybuilding_plan.id = labour_factorybuilding_decisions.complaint_id');
								$where = "date(`labour_factorybuilding_decisions`.`modified`)>='".$srch['sdate']."' AND date(`labour_factorybuilding_decisions`.`modified`)<='".$srch['edate']."'";	
								$this->slaveDB->where($where);
							}
						}
					}
				}
			}
			
			
			if(!empty($srch['keyword'])) {				
				if(is_numeric($srch['keyword'])){
					
					$this->slaveDB->join("factory_registrations as reg_f","reg_f.factory_reg_id = labour_factorybuilding_plan.factory_reg_id");
					$this->slaveDB->group_start();
					$this->slaveDB->where('labour_factorybuilding_plan.factory_reg_id',$srch['keyword']);
					$this->slaveDB->or_where('labour_factorybuilding_plan.id',$srch['keyword']);
					$this->slaveDB->or_where('reg_f.cafpin',$srch['keyword']);
					$this->slaveDB->group_end();
				}
				else{
					$like = "(labour_factorybuilding_plan.plant LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR labour_factorybuilding_plan.factory_name LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%' OR  `labour_factorybuilding_plan`.`factory_address` LIKE '%".preg_replace("/'/", "\&#39;",$srch['keyword'])."%') ";
					$this->slaveDB->where($like);
				}	
			}
			if($srch['list_type']=='bip_wise') {	
				if($srch['keyword_app_id']!="") {
                    if(is_numeric(trim($srch['keyword_app_id']))) {
                        $this->slaveDB->where('labour_factorybuilding_plan.id',$srch['keyword_app_id']);
					}
					} else {
                    $this->slaveDB->join('(SELECT max(id) id FROM labour_factorybuilding_plan GROUP BY factory_reg_id) app2','labour_factorybuilding_plan.id = app2.id','inner');
				}
				$result= $this->slaveDB->order_by('labour_factorybuilding_plan.id','ASC')->get()->result_array();	
			}else{
				$result= $this->slaveDB->order_by('labour_factorybuilding_plan.factory_reg_id','ASC')->get()->result_array();	
			}
			if(isset($_GET['pr'])){
				echo  $this->slaveDB->last_query();
			}
			return $result;
			
		}
		/*			
			AddedDate: 20 Sept 2016
			AddedBy: harjot
			FunctionName: getDistrict
			Purpose: Fetch deptt officer's privileges on the basis of privilege id
		*/
		public function getDistrict(){
			$this->db->where("states_id",1);			
			$query = $this->db->from("labour_distt")->get();			
			return $query->result_array();
		}
		/*			
			AddedDate: 9th May 2017
			AddedBy: Rakesh 
			FunctionName: get_certificate_info
			Purpose: get certificate info of building plan
		*/
		public function get_certificate_info($plan_id)
		{
			return $this->db->select('*')->from('labour_factorybuilding_plan as plan')->join('labour_factorybuilding_plan_cert as cert','plan.id	=	cert.complaint_id')->where('plan.id', $plan_id)->order_by('cert.id','DESC')->get()->row_array();
		}
		
		public function get_distt_code($fact_dist_id)
		{
			$result		=	$this->db->select('*')->from('labour_distt')->where('distt_id',$fact_dist_id)->get()->row_array();			
			return $dist_code	=	$result['distt_code'];
		}
		
		public function saveCertificate($data){
			$this->db->insert('labour_factorybuilding_plan_cert',$data);
		}
		
		public function updateCertificate($data,$id){
			$this->db->where("complaint_id",$id);
			$this->db->update("labour_factorybuilding_plan_cert",$data);
		}

		public function getCertifData($id){
			$this->db->where("complaint_id",$id);
			$query = $this->db->from("labour_factorybuilding_plan_cert")->get();			
			return $query->row_array();
		}
		/*			
			AddedDate: 05-Aug-2017
			AddedBy: Jatin
			FunctionName: get_factory_decision_date
			Purpose: get Latest Date according to Status
		*/
		public function get_factory_decision_date($id)
		{
			$this->db->where('complaint_id',$id);
			$info = $this->db->select('modified')->from('labour_factorybuilding_decisions')->get()->row_array();
			return $info;
		}
		public function uploadBuldingPlanLicence($data,$reg_id,$lic_id)
		{
			$this->db->update('labour_factorybuilding_plan',$data,array('factory_reg_id'=>$reg_id,'id'=>$lic_id));
			//echo $this->db->last_query();die;
		}
		
		/**
			*	AddedDate: 12 April 2018;
			*	AddedBy: Sonia
			*	FunctionName:  countRejections
			*	Purpose: count no of rejections
		**/
		public function countRejections($plan_id){
			$this->db->where("plan_id",$plan_id);
			$this->db->where("rej_status",'0');
			$query = $this->db->from("labour_factorybuilding_rejection")->get();			
			return $query->result_array();
			
		}
		
		/*			
			AddedDate: 12 April 2018;
			AddedBy: Sonia
			FunctionName: editObjection
			Purpose: Edit Objection record 
		*/
		public function editRejection($data,$id){
			$this->db->where("rej_id",$id);
			$this->db->update("labour_factorybuilding_rejection",$data);
			return true;
		}
		/*			
			AddedDate: 12 April 2018;
			AddedBy: Sonia
			FunctionName: getLatestObjection
			Purpose: Get latest objection by license ID
		*/
		public function getLatestRejection($id){
			$sql = "SELECT MAX(rej_id) as id FROM labour_factorybuilding_rejection WHERE plan_id = '".$id."' ";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		
		/*			
			AddedDate: 12 April 2018;
			AddedBy: Sonia
			FunctionName: getObjectionById
			Purpose: Get objection by Id
		*/
		public function getRejectionById($id){
			$this->db->where("rej_id",$id);
			$query = $this->db->from("labour_factorybuilding_rejection")->get();
			return $query->row_array();
		}
		
		/*			
			AddedDate: 12 April 2018;
			AddedBy: Sonia
			FunctionName: addObjection
			Purpose: Add Objection record 
		*/
		public function addRejection($data){							
			$this->db->insert("labour_factorybuilding_rejection",$data);
			return $this->db->insert_id();
		}	
		
		/*			
			AddedDate: 25 April 2016
			AddedBy: Sonia
			FunctionName: getObjection
			Purpose: Fetch Objections on a license application
		*/
		public function getRejection($licId){
			return $this->db->select('*')->from("labour_factorybuilding_rejection")->where(array('rej_status'=>'1','plan_id'=>$licId))->get()->result_array();			
		}		
		
		public function getObjectionsByLic($planid){
			$this->db->where('plan_id',$planid);
			$this->db->where('obj_status',1);
			return $this->db->select('count(*) as total')->from('labour_factorybuilding_objection')->get()->row_array();
		}
		/*			
			AddedDate: 12-July-2018
			AddedBy: Deepa
			FunctionName: get_rejection_date
			Purpose: get rejection
		*/
		public function get_rejection_date($id)
		{
			$this->db->where('plan_id',$id);
			$info = $this->db->select('rej_created')->from('labour_factorybuilding_rejection')->get()->row_array();
			return $info;
		}
		
		public function add_update_fb_sign_doc($data, $type=null){
			if($type!=null) {
				$this->db->where('type',$type);
			}
			$query = $this->db->get_where('rc_doc_sign_status', array('app_id' => $data['app_id'], 'cert_id' => $data['cert_id']));
			$result = $query->row_array();
			if($result){
				$id = $result['id'];
				$this->db->where('id', $id);
	        	$this->db->update('rc_doc_sign_status', $data);
				} else {
				if(!empty($_GET['deptType'])) {
					$data['type'] = $_GET['deptType'];
				}
				$this->db->insert('rc_doc_sign_status', $data); 
			}
			
			if ($data['cert_pdf']=='1') {
				$ulnk = base64_decode($_GET['app_server_file']);
				$baseurl = base_url();
				$rootDir = str_replace($baseurl, '', $ulnk);
				$dmter = 'Y' . date('Y');
				$dirs = explode($dmter, $rootDir);
				if (!empty($dirs)) {
					//$delLoc = $dirs[0] . $dmter . '/';
					//delete_files($delLoc, true); // delete all files/folders
					$delLoc = $dirs[0];
					//unlink($_SERVER['DOCUMENT_ROOT'].'/'.$delLoc);
				}
			}
			if($type!=null) {
				$this->db->where('type',$type);
			}
			$query = $this->db->get_where('rc_doc_sign_status', array('app_id' => $data['app_id'], 'cert_id' => $data['cert_id']));
			return $query->row_array();
			
		}
		
		public function get_fb_sign_doc($planid, $factory_id, $type=null){
			if($type!=null) {
				$this->db->where('type',$type);
			}
			$query = $this->db->get_where('rc_doc_sign_status', array('app_id' => $planid, 'cert_id' => $factory_id,'scrunity_pdf' => 1));
			return $query->row();
		}
		public function updateBlueprintChecked($planid,$val){
			$status_array	=	array('temp_check'=>$val);
			$this->db->where('id', $planid);
			$this->db->update('labour_factorybuilding_plan',$status_array);
		}
		public function getBlueprintChecked($planid){
			$info = $this->db->select('temp_check')->from('labour_factorybuilding_plan')->where('id',$planid)->get()->row();
			return $info;
		}
		
		public function update_blueprint_checked($status_array,$planid){
			$this->db->where('id', $planid);
			return $this->db->update('labour_factorybuilding_plan',$status_array);
		}
		
		public function get_fb_cert_doc($planid, $factory_id, $type=null){
			if($type!=null) {
				$this->db->where('type',$type);
			}
			$query = $this->db->get_where('rc_doc_sign_status', array('app_id' => $planid, 'cert_id' => $factory_id,'cert_pdf' => 1));
			return $query->row();
		}
		
		public function getFactorybuildingBlueprints($planid){
			$info = $this->db->select('file')->from('labour_factorybuilding_blueprints')->where('plan_id',$planid)->order_by('id',DESC)->get()->row();
			return $info;
			
		}
		
		public function getFactorybuildingForm1b($planid){
			$info = $this->db->select('local_signature_uploaded_pdf')->from('labour_factorybuilding_form1b')->where('plan_id',$planid)->get()->row_array();
			return $info;
		}
		
		/*			
			AddedDate: 03-March-2016
			AddedBy: Sonia
			FunctionName: getLicenseDetail
			Purpose: Get license details of last application submitted
		*/
		public function getBuildingPlanDetail($plan_id){
			$query = $this->db->query("SELECT * FROM labour_factorybuilding_plan WHERE id = ".$plan_id);				
			return $query->row_array();
		}
		
		public function getChecklist($plan_id) {
			return $this->db->select('*')->from('labour_factorybuilding_checklist')->where(array('plan_id'=>$plan_id))->get()->row_array();
		}
		
		/*officers at second step - to equally divide the applications*/
		public function getFBPOfficers($ofcrstep){
			return $this->db->from('labour_admin_job_detail')->where('job_type',12)->where('fbp_officers',$ofcrstep)->get()->result_array();
		}
		
		public function getFBPOfficerStep5($ofcrstep,$circle){
			return $this->db->from('labour_admin_job_detail')->where('job_type',12)->like('director_area_id','-'.$circle.'-')->where('fbp_officers',$ofcrstep)->get()->result_array();
		}
		
		public function countMinAppsByOfficers($ofcrstep){
			$sql 	=	'SELECT * FROM `labour_admin_job_detail` WHERE job_type = 12 AND `fbp_officers` = '.$ofcrstep.' AND fbp_count_apps = (SELECT MIN(fbp_count_apps) from labour_admin_job_detail where job_type = 12 AND fbp_officers = '.$ofcrstep.')';
			$query 	= 	$this->db->query($sql);
			$result =	$query->row_array(); 
			
			return $result;
		}
		
		public function countMinAppsByOfficersFBP5($ofcrstep,$circle){
			$sql 	=	'SELECT * FROM `labour_admin_job_detail` WHERE job_type = 12 AND `fbp_officers` = '.$ofcrstep.' AND director_area_id LIKE "%-'.$circle.'-%" AND fbp_count_apps = (SELECT MIN(fbp_count_apps) from labour_admin_job_detail where job_type = 12 AND fbp_officers = '.$ofcrstep.' AND director_area_id LIKE "%-'.$circle.'-%")';
			$query 	= 	$this->db->query($sql);
			$result =	$query->row_array(); 
			
			return $result;
		}
		
		public function updateFBPCount($data){
			$this->db->where('job_id',$data['jobid']);
			$this->db->where('job_type',12);
			$this->db->update('labour_admin_job_detail',array('fbp_count_apps' => $data['count']));
		}
		
		public function getAdminFBPCount($job_id){
			return $this->db->from('labour_admin_job_detail')->where('job_id',$job_id)->where('job_type',12)->get()->row_array();
		}
		
		public function getStepByJobID($jobid){
			return $this->db->select('fbp_officers')->from('labour_admin_job_detail')->where('job_id',$jobid)->where('job_type',12)->get()->row_array();
		} 
		// verification_officer_jobid
		public function get_total_verificationapp($jobid){
			$sql 	=	'SELECT * FROM factoryplan_application_verification WHERE verification_officer_jobid = '.$jobid.' AND reply_status = 0';
			$query 	= 	$this->db->query($sql);
			$result =	$query->result_array(); 
			
			return $result;
		}
		public function getallverificationsfb($factid,$lid){
			$sql 	=	'SELECT * FROM factoryplan_application_verification WHERE factory_reg_id  = '.$factid.' AND plan_id = '.$lid.' order by id ASC';
			$query 	= 	$this->db->query($sql);
			$result =	$query->result_array(); 
			
			return $result;
		}
		
		public function getreply_onverification($factid,$lid,$vid){ 
			$sql 	=	'SELECT * FROM factoryplan_application_verificationreply WHERE factory_reg_id = '.$factid.' AND plan_id = '.$lid.' AND verification_appid = '.$vid.' order by id ASC';
			$query 	= 	$this->db->query($sql);
			$result =	$query->row_array(); 
			
			return $result;
		}
		public function getlatest_verification($factid,$lid){
			$sql 	=	'SELECT * FROM factoryplan_application_verification WHERE factory_reg_id = '.$factid.' AND plan_id  = '.$lid.' order by id DESC';
			$query 	= 	$this->db->query($sql);
			$result =	$query->row_array(); 
			//echo $this->db->last_query(); die;
			return $result;
		}
		public function exempt_verification($verificationid){
			$this->db->where('id',$verificationid);
			$this->db->update('factoryplan_application_verification',array('reply_status' => 2));
		}
		public function insert_verification_factory($data)
		{
			$this->db->insert("factoryplan_application_verification", $data);
			//echo $this->db->last_query(); die;
			return $this->db->insert_id();
		}
		public function getlist_toverify_count($jobid){
			$this->db->where("reply_status",0);
			$this->db->where("assigned_to_officerjobid ",$jobid);
			$this->db->select("*");
			$this->db->from("factoryplan_application_verification");
			$query = $this->db->get();
			return $query->result_array();
			//echo $this->db->last_query(); die;
		}
		public function getlist_toverify($jobid,$limit = NULL,$offset = NULL){
			$this->db->where("reply_status",0);
			$this->db->where("assigned_to_officerjobid ",$jobid);
			if ($limit != NULL || $offset != NULL) {
				$this->db->limit($limit, $offset);
			}
			$this->db->select("verify.*,reg.factory_reg_u_name");
			$this->db->from("factoryplan_application_verification as verify");
			$this->db->join("factory_registrations as reg", "verify.factory_reg_id = reg.factory_reg_id");
			$query = $this->db->get();
			return $query->result_array();
			//echo $this->db->last_query(); die;
		}		
		public function getverifyDetail($vid){
			return $this->db->from('factoryplan_application_verification')->where('id',$vid)->get()->row_array();
		}
		public function insert_verificationreply_factory($data)
		{
			$this->db->insert("factoryplan_application_verificationreply", $data);
			//echo $this->db->last_query(); die;
			return $this->db->insert_id();
		}
		public function update_reply_status($verificationid){
			$this->db->where('id',$verificationid);
			$this->db->update('factoryplan_application_verification',array('reply_status' => 1));
		}
		
		public function get_published_date($id)
		{
			$this->db->where('complaint_id',$id);
			$info = $this->db->select('date_published')->from('labour_factorybuilding_plan_cert')->get()->row_array();
			return $info;
		}
		
		public function insertJDComment($data){
			$this->db->insert('labour_factorybuilding_jdcomment',$data);
		}
		
		public function getJDCommentList($licid){
			return $this->db->where('complaint_id',$licid)->from('labour_factorybuilding_jdcomment')->get()->row_array();
		}

		// public function getPlan_form1_logs($plan_id){
		// 	$this->db->order_by('id','desc');
		// 	$this->db->limit(1);
		// 	return $this->db->select('contents')->from('labour_factorybuilding_form1_logs')->where(array('plan_id'=>$plan_id))->get()->row_array();
		// }

		public function getPlan_form1_logs($plan_id){
			$this->db->order_by('id','desc');
			return $this->db->select('contents,created_date')->from('labour_factorybuilding_form1_logs')->where(array('plan_id'=>$plan_id))->get()->result_array();
		}


		public function get_applications($srch=NULL, $limit = NULL, $offset = NULL){

			 if (isset($srch) && !empty($srch['keyword'])) {
				$this->db->group_start(); 
		
				//$this->db->like('reg.factory_reg_u_name', $srch['keyword']);

				$this->db->or_where('bp.factory_reg_id', $srch['keyword']);
				//$this->db->or_where('bp.plant', $srch['keyword']);

				$this->db->group_end();
       		 }
			  if (isset($srch) && !empty($srch['district'])) {
				$this->db->where('reg.factory_reg_u_district', $srch['district']);
			  }

			if((isset($srch['sdate']) && $srch['sdate'] != "") && (isset($srch['edate']) && $srch['edate'] != "") )
             {
				 $this->db->where("bp.modified_date >= ", $srch['sdate'] . " 00:00:00");
				 $this->db->where("bp.modified_date <= ", $srch['edate'] . " 23:59:59");
             }

			$this->db->where('bp.final_status !=', 0);
			$this->db->order_by('bp.id', 'DESC');
			$this->db->limit($limit, $offset);
			$this->db->join("factory_registrations reg", "reg.factory_reg_id = bp.factory_reg_id");
			$result = $this->db->select('bp.*, reg.factory_reg_u_name, reg.factory_reg_u_district')->from('labour_factorybuilding_plan bp')->get()->result_array();
		
			return $result;
		}

		public function get_applications_count($srch=NULL){
			 if (isset($srch) && !empty($srch['keyword'])) {
				$this->db->group_start(); 
		
				//$this->db->like('reg.factory_reg_u_name', $srch['keyword']);

				$this->db->or_where('bp.factory_reg_id', $srch['keyword']);
				//$this->db->or_where('bp.plant', $srch['keyword']);

				$this->db->group_end();
       		 }
			  if (isset($srch) && !empty($srch['district'])) {
				$this->db->where('reg.factory_reg_u_district', $srch['district']);
			  }

			if((isset($srch['sdate']) && $srch['sdate'] != "") && (isset($srch['edate']) && $srch['edate'] != "") )
             {
				 $this->db->where("bp.modified_date >= ", $srch['sdate'] . " 00:00:00");
				 $this->db->where("bp.modified_date <= ", $srch['edate'] . " 23:59:59");
             }

			$this->db->where('bp.final_status !=', 0);
			$this->db->order_by('bp.id', 'DESC');
			$this->db->join("factory_registrations reg", "reg.factory_reg_id = bp.factory_reg_id");
			$result = $this->db->select('count(*) total')->from('labour_factorybuilding_plan bp')->get()->row_array()['total'];
			return $result;

		}

		public function getLcPurposes() {
			$this->db->where('active', 1);
			$query = $this->db->get('markedto_propose_action');
			return $query->result_array();
		}
		
		public function saveMarkedApplicationLC($data) {
			$this->db->insert('marked_applications_lc', $data);
			return $this->db->insert_id();
		}

		public function getLcPurposeCounts($type) {
			$subquery = "(
				SELECT max_lc.app_id, max_lc.markedto_proposeId
				FROM marked_applications_lc max_lc
				INNER JOIN (
					SELECT MAX(id) as latest_id 
					FROM marked_applications_lc 
					WHERE act = 'factory_building_plan'
					GROUP BY app_id
				) latest ON max_lc.id = latest.latest_id
			) latest_marked_reason";
			$query = $this->db->select('latest_marked_reason.markedto_proposeId, COUNT(latest_marked_reason.app_id) as total_count')
							->from($subquery)
							->group_by('latest_marked_reason.markedto_proposeId')
							->get()
							->result_array();

			$counts = array();
			foreach ($query as $row) {
				if (!empty($row['markedto_proposeId'])) {
					$counts[$row['markedto_proposeId']] = $row['total_count'];
				}
			}
			return $counts;
		}

		
	}					
