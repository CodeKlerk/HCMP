<?php
ob_start();


class auto_sms extends MY_Controller {
	var $flaged = "";
		//this sends the sms to all recepients regarding the stocked out vaccine *_*
	
	public function expired_commodities(){
		//////////////////////////////////////////////////////////////////////////////////////////
		$facility_c=$this -> session -> userdata('news');
		$count=Facility_Stock::get_exp_count($date,$facility);
		$facility_array = Update_stock_first_temp::get_facility_name($facility_c);
		
			foreach ($facility_array as $info) {
			$facility_name = $info->facility_name;
			}
	
		$data=User::get_user_info();      
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone = $info->telephone;
			$district = $info->district;
			$facility = $info->facility;
		
		if(($usertype_id== 1 ) && ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name."has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));	
		
		}else if(($usertype_id== 2 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 3 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 4 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 5 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}
		 
	}

	}
	 public function Orders_pending_approval ()	{

		$facility_c=$this -> session -> userdata('news');
		$count=Ordertbl::get_pending_count($facility_c);
		$facility_array =Update_stock_first_temp::get_facility_name($facility_c);
		
			foreach ($facility_array as $info) {
			$facility_name = $info->facility_name;
			$disto = $info->district;	
			}
	
		$data=User::get_user_info();      
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone = $info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		
		if(($usertype_id== 1 ) && ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));	
		
		}else if(($usertype_id== 2 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 3 )&& ($district == $disto)){
			
		$phones=$telephone;
		$message= " ".$facility_name." 
		has ".$count." Orders pending approval.Please approve";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 4 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has  , Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 5 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));
		
		}
	}	
	}
public function Orders_pending_dispatch ()	{

		$facility_c=$this -> session -> userdata('news');
		$count=Ordertbl::get_pending_o_count($d='');
		$facility_array =Update_stock_first_temp::get_facility_name($facility_c);
		
			foreach ($facility_array as $info) {
			$facility_name = $info->facility_name;
			$disto = $info->district;	
			}
	
		$data=User::get_user_info();      
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone = $info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		
		if(($usertype_id== 1 ) && ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));	
		
		}else if(($usertype_id== 2 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 3 )&& ($district == $disto)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 4 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 5 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		
		$this->send_sms($phones,urlencode($message));
		
		}
	}		
	}
public function send_sms($phones,$message) {
	
   $message=urlencode($message);	
   $spam_sms='254720167245+254726534272';
 	# code...
 	file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$spam_sms&text=$message");
 

			
	file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$message");


		

	}


public function send_email($email_address,$message,$name){
	
			$fromm='hcmpkenya@gmail.com';
		    $messages=$message;

  		$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'hcmpkenya@gmail.com';
        $config['smtp_pass']    = 'healthkenya';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not  
		$this->load->library('email', $config);

        $this->email->initialize($config);
		
 
  		$this->email->set_newline("\r\n");
  		$this->email->from($fromm,'Health Commodities Management Platform'); // change it to yours
  		$this->email->to($email_address); // change it to yours
  		$this->email->bcc('kariukijackson@gmail.com,kelvinmwas@gmail.com');
  		$this->email->subject('User Registration :'.$name);
 		$this->email->message($messages);
 
  if($this->email->send())
 {

 }
 else
{
 show_error($this->email->print_debugger());
}
}
	
		

}
