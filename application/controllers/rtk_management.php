<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once('home_controller.php');

class Rtk_Management extends Home_controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {

        echo "Jack";
    }

    public function rtk_mapping() {
        $data = array();
        $data['title'] = "Facility Mapping";
        $data['banner_text'] = "Facility Mapping";

        $data['content_view'] = "rtk/facility_mapping_v";



        $this->load->view("template", $data);
    }

    public function county_rtk_mapping() {
        $data = array();
        $data['title'] = "Facility Mapping";
        $data['banner_text'] = "Facility Mapping";

        $data['content_view'] = "";

        $data['county'] = Counties::getAll();


        $owner_array = array("GOK", "CBO", "FBO", "NGO", "Private", "Other");
        $counties = Counties::getAll();
        ;
        $table_body = '';

        foreach ($counties as $county_detail) {
            $id = $county_detail->id;
            $table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='get_rtk_county_detail/$id' href='#'> $county_detail->county </a></td>";

            $county_detail = facilities::get_total_facilities_rtk($id);

            $table_body .="<td>" . $county_detail[0]['total_facilities'] . "</td><td>" . $county_detail[0]['total_rtk'] . "</td>";
            foreach ($owner_array as $key => $value) {

                $owner_count = facilities::get_total_facilities_rtk_ownership($id, $value);


                $table_body .="<td>" . $owner_count[0]['ownership_count'] . "</td>";
            }
            $table_body .="</tr>";
        }

        $data['table_body'] = $table_body;

        $this->load->view("rtk/ajax_view/county_rtk_v", $data);
    }

    public function get_rtk_county_detail($county_id) {
        $data['title'] = "Facilities";
        //	$data['content_view'] = "facilities_rtk_v";
        $data['banner_text'] = "Facility List";
        $data['link'] = "rtk_management";
        $data['doghnut'] = "county";
        $data['bar_chart'] = "county";
        $data['county_id'] = $county_id;
        //////////////////////owners
        $data['facility'] = Facilities::get_total_facilities_rtk_in_county($county_id);
        $data['quick_link'] = "commodity_list";
        $this->load->view("rtk/ajax_view/rtk_facility_list_v", $data);
    }

    public function get_rtk_county_distribution_allocation_detail() {
        $distribution_allocation_data = rtk_stock_status::get_rtk_alloaction_distribution(1);
        $distribution_allocation_data_1 = rtk_stock_status::get_rtk_alloaction_distribution(2);

        $table_body = "";
        $table_body_1 = "";

        foreach ($distribution_allocation_data as $data_1) {
            $table_body .="<tr><td>$data_1[county]</td><td>$data_1[qty_requested]</td>
			<td>$data_1[distributed]</td><td>$data_1[allocated]</td></tr>";
        }

        foreach ($distribution_allocation_data_1 as $data_2) {
            $table_body_1 .="<tr><td>$data_2[county]</td><td>$data_2[qty_requested]</td>
			<td>$data_2[distributed]</td><td>$data_2[allocated]</td></tr>";
        }
        $data['table_body'] = $table_body;
        $data['table_body_1'] = $table_body_1;
        $this->load->view("rtk/ajax_view/rtk_allocation_dist_v", $data);
    }

    public function get_report($facility_code) {


        $data['title'] = "Lab Commodities 3 Report";
        $data['content_view'] = "rtk/lab_commodities_v";
        $data['banner_text'] = "Lab Commodities 3 Report";
        $data['link'] = "rtk_management";
        $data['quick_link'] = "commodity_list";
        // $data['popout'] = $msg;
        //The district has been set to 1 until this user is given a specific district
        // $data['facilities']=Facilities::get_facility_details(6);
        $data['facilities'] = Facilities::get_one_facility_details($facility_code);
        $data['lab_categories'] = Lab_Commodity_Categories::get_all();
        $this->load->view("template", $data);
    }

    public function sendmail($output, $reportname) {
        $this->load->helper('file');
        //  $email_address = 'williamnguru@gmail.com';
        //    $message = 'Hi William';
        //      $subject = 'no subject today';
        include 'auto_sms.php';
//        $output = 'This is the output that should be stated on the pdf';

        $newmail = new auto_sms();
        $this->load->library('mpdf');
        $mpdf = new mPDF();

        $mpdf->WriteHTML($output);
        $emailAttachment = $mpdf->Output($reportname . '.pdf', 'S');
//	$emailAttachment = chunk_split(base64_encode($emailAttachment));
//	echo $emailAttachment;
        $attach_file = './pdf/' . $reportname . '.pdf';
//	$newmail->send_email($email_address,$message,$subject,$emailAttachment,$bcc_email=NULL);
        if (!write_file('./pdf/' . $reportname . '.pdf', $mpdf->Output('report_name.pdf', 'S'))) {
            $this->session->set_flashdata('system_error_message', 'An error occured');
        } else {
            $email_address = "williamnguru@gmail.com";
            $subject = 'Order Report For ' . $reportname;

            $attach_file = './pdf/' . $reportname . '.pdf';
            $bcc_email = 'billnguts@gmail.com';
            $message = $output;
            $response = $newmail->send_email($email_address, $message, $subject, $attach_file, $bcc_email);
            // $response= $newmail->send_email(substr($email_address,0,-1),$message,$subject,$attach_file,$bcc_email);
            if ($response) {
                delete_files('./pdf/' . $reportname . '.pdf');
            }
        }
    }

    function gen_email() {
        $thereport = $this->generate_lastpdf();
//        echo $thereport;
        $this->sendmail($thereport);
        echo "sent";
    }

    function generate_lastpdf() {

//         $order_no = Lab_Commodity_Orders::getlastid();
        $this->load->database();
        $query = $this->db->query('SELECT id
    	    	FROM  `lab_commodity_orders` 
    	    	ORDER BY  `lab_commodity_orders`.`id` DESC 
    	    	LIMIT 0 , 1');
        $order_no;
        foreach ($query->result_array() as $row) {
            $order_no = $row['id'];
        }


        $query1 = $this->db->query('SELECT * 
            FROM lab_commodity_orders, facilities, districts,counties
            WHERE lab_commodity_orders.district_id = districts.id
            AND counties.id = districts.county
            AND facilities.facility_code = lab_commodity_orders.facility_code
            AND lab_commodity_orders.id =' . $order_no . '');
        $lab_order = $query1->result_array();
        //  echo '<pre>';
        //    var_dump($lab_order);
        //      echo '</pre>';
//        $lab_order = lab_commodity_orders::get_single_lab_order($order_no);


        date_default_timezone_set("EUROPE/Moscow");
        $firstday = date('D dS M Y', strtotime("first day of previous month"));
        $lastday = date('D dS M Y', strtotime("last day of previous month"));
        $lastmonth = date('F', strtotime("last day of previous month"));

        //    echo "<pre>";
        //           var_dump($lab_order);
        //      echo "</pre>";



        $html_title = "<div ALIGN=CENTER><img src='" . base_url() . "Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-size: 14px;display: block;font-weight: bold;'>RTK FCDRR Report for " . $lab_order[0]['facility_name'] . "  $lastmonth  2013</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
       Ministry of Health</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div><hr />";
        $table_head = '
        <table border="0" style="width: 100%; margin: 10px auto;">
<tr><td style="text-align:left"><b>Name of Facility:</b></td>
                        <td colspan="2">' . $lab_order[0]['facility_name'] . '</td>
                        
                        <td colspan="3"><b>Applicable to HIV Test Kits Only</b></td>
                        <td colspan="2"></td>
                        <td colspan="4" style="text-align:center"><b>Applicable to Malaria Testing Only</b></td>
                  
                    </tr>
<tr><td colspan="2" style="text-align:left"><b>MFL Code:</b></td>
                        <td>12982</td>
                        <td colspan="2" style="text-align:center"><b>Type of Service</b></td>
                        <td colspan="1" style="text-align:center"><b>No. of Tests Done</b></td>
                        <td colspan="2"></td>
                        <td colspan="1"><b>Test</b></td>
                        <td colspan="1"><b>Category</b></td>
                        <td colspan="1"><b>No. of Tests Performed</b></td>
                        <td colspan="1"><b>No. Positive</b></td>                            
                    </tr>
<tr><td colspan="2" style="text-align:left"><b>District:</b></td>
                        <td>' . $lab_order[0]['district'] . '</td>
                        <td colspan="2"><b>VCT</b></td>
                        <td>' . $lab_order[0]['vct'] . '</td>
                        <td colspan="2"></td>
                        <td rowspan="3">RDT</td>
                        <td style="text-align:left">Patients&nbsp;<u>under</u> 5&nbsp;years</td>
                        <td>' . $lab_order[0]['rdt_under_tests'] . '</td>
                        <td>' . $lab_order[0]['rdt_under_pos'] . '</td>                          
                    
                        </tr>
<tr><td colspan="2" style="text-align:left"><b>County:</b></td>                     
                        <td>' . $lab_order[0]['county'] . '</td>
                        <td colspan="2"><b>PITC</b></td>
                        <td>' . $lab_order[0]['pitc'] . '</td>
                        <td colspan="2"></td>
                        <td style="text-align:left">Patients&nbsp;aged 5-14&nbsp;yrs</td>
                            <td>' . $lab_order[0]['rdt_btwn_tests'] . '</td>
                            <td>' . $lab_order[0]['rdt_btwn_pos'] . '</td>                        </tr>
<tr><td colspan="2" style="text-align:right"><b>Beginning:</b></td> 
                        <td>' . $firstday . '</td>
                        <td colspan="2"><b>PMTCT</b></td>
                        <td>' . $lab_order[0]['pmtct'] . '</td>
                        <td colspan="2"></td>
                        <td style="text-align:left">Patients&nbsp;<u>over</u> 14&nbsp;years</td>
                        <td>' . $lab_order[0]['rdt_over_tests'] . '</td>
                        <td>' . $lab_order[0]['rdt_over_pos'] . '</td>
                        
                        </tr>
<tr><td colspan="2" style="text-align:right"><b>Ending:</b></td>
                        <td>' . $lastday . '</td>
                        <td colspan="2"><b>Blood&nbsp;Screening</b></td>
                        <td>' . $lab_order[0]['b_screening'] . '</td>
                        <td colspan="2"></td>
                        <td rowspan="3">Microscopy</td>
                        <td style="text-align:left">Patients&nbsp;<u>under</u> 5&nbsp;years</td>
                        <td>' . $lab_order[0]['micro_under_tests'] . '</td>
                        <td>' . $lab_order[0]['micro_under_pos'] . '</td>                          
                    </tr>
<tr><td colspan="3"></td>
                        <td colspan="2"><b>Other&nbsp;(Please&nbsp;Specify)</b></td>
                        <td>' . $lab_order[0]['other'] . '</td> 
                        <td colspan="2"></td>
                        <td style="text-align:left">Patients&nbsp;aged 5-14&nbsp;yrs</td>
                        <td>' . $lab_order[0]['micro_btwn_tests'] . '</td>
                        <td>' . $lab_order[0]['micro_btwn_pos'] . '</td>
                        </tr>
                        <tr><td colspan="3"></td>
                            <td colspan="2"><b>Specify&nbsp;Here:</b></td>
                            <td>' . $lab_order[0]['specification'] . '</td>   
                            <td colspan="2"></td>
                            <td style="text-align:left">Patients&nbsp;<u>over</u> 14&nbsp;years</td>
                            <td>' . $lab_order[0]['micro_over_tests'] . '</td>
                            <td>' . $lab_order[0]['micro_over_pos'] . '</td>
                        </tr></table>';
        $table_head .= '<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#D8D8D8;}</style></table>
<table class="data-table" width="100%">
<thead>
<tr>
<th><strong>Category</strong></th>
	<th><strong>Description</strong></th>
	<th><strong>Unit of Issue</strong></th>
	<th><strong>Beginning Balance</strong></th>
	<th><strong>Quantity Received</strong></th>
	<th><strong>Quantity Used</strong></th>
	<th><strong>Number of Tests Done</strong></th>
	<th><strong>Losses</strong></th>
	<th><strong>Positive Adjustments</strong></th>
	<th><strong>Negative Adjustments</strong></th>
	<th><strong>Closing Stock</strong></th>
	<th><strong>Quantity Expiring in 6 Months</strong></th>
	<th><strong>Days Out of Stock</strong></th>
	<th><strong>Quantity Requested</strong></th>
</tr>
</thead>
<tbody>';
        $detail_list = Lab_Commodity_Details::get_order($order_no);

        $table_body = '';
        foreach ($detail_list as $detail) {
            $table_body.='<tr><td>' . $detail['category_name'] . '</td>';
            $table_body.='<td>' . $detail['commodity_name'] . '</td>';
            $table_body.='<td>' . $detail['unit_of_issue'] . '</td>';
            $table_body.='<td>' . $detail['beginning_bal'] . '</td>';
            $table_body.='<td>' . $detail['q_received'] . '</td>';
            $table_body.='<td>' . $detail['q_used'] . '</td>';
            $table_body.='<td>' . $detail['no_of_tests_done'] . '</td>';
            $table_body.='<td>' . $detail['losses'] . '</td>';
            $table_body.='<td>' . $detail['positive_adj'] . '</td>';
            $table_body.='<td>' . $detail['negative_adj'] . '</td>';
            $table_body.='<td>' . $detail['closing_stock'] . '</td>';
            $table_body.='<td>' . $detail['q_expiring'] . '</td>';
            $table_body.='<td>' . $detail['days_out_of_stock'] . '</td>';
            $table_body.='<td>' . $detail['q_requested'] . '</td></tr>';
        }
        $table_foot = '</tbody></table>';

        $table_foot .='
        <table border="0" style="width: 100%;border: 1px solid #DDD;margin: 10px auto;">
 <tr>                   
                        <td style="text-align:left">Explaination of Losses and Adjustments</td><td  style="
    width: 57%;
">' . $lab_order[0]['explanation'] . '</td>
                        
                    </tr>
                    <tr style="
    background: #ECE8FD;
">
                        
               
                        <td  ><b>(1) Daily Activity Register for Laboratory Reagents and Consumables (MOH 642):</b></td><td>' . $lab_order[0]['moh_642'] . '</td>
                        
                        </tr><tr>
                        <td  ><b>(2) F-CDRR for Laboratory Commodities (MOH 643):</b></td><td>' . $lab_order[0]['moh_643'] . '</td>
                         
                    </tr><tr style="
    background: #ECE8FD;
">                   
                    <td style="text-align:left">Compiled by: </td><td>' . $lab_order[0]['compiled_by'] . '</td>
 
                        </tr> 
     </table>';
        $report_name = "Lab Commodities Order " . $order_no . " Details";
        $title = "Lab Commodities Order " . $order_no . " Details";
        $html_data = $html_title . $table_head . $table_body . $table_foot;
//return $html_data;
        time();

        $filename = "RTK FCDRR Report for " . $lab_order[0]['facility_name'] . "  $lastmonth  2013";
        //    echo $html_data;
        $this->sendmail($html_data, $filename);
//        $this->sendmail($html_data, $filename);
    }

    public function save_lab_report_data() {


        $district_id = $_POST['district'];
        $facility_code = $_POST['facility_code'];
        $drug_id = $_POST['commodity_id'];
        $unit_of_issue = $_POST['unit_of_issue'];
        $b_balance = $_POST['b_balance'];
        $q_received = $_POST['q_received'];
        $q_used = $_POST['q_used'];
        $tests_done = $_POST['tests_done'];
        $losses = $_POST['losses'];
        $pos_adj = $_POST['pos_adj'];
        $neg_adj = $_POST['neg_adj'];
        $physical_count = $_POST['physical_count'];
        $q_expiring = $_POST['q_expiring'];
        $days_out_of_stock = $_POST['days_out_of_stock'];
        $q_requested = $_POST['q_requested'];
        $commodity_count = count($drug_id);

        $vct = $_POST['vct'];
        $pitc = $_POST['pitc'];
        $pmtct = $_POST['pmtct'];
        $b_screening = $_POST['blood_screening'];
        $other = $_POST['other2'];
        $specification = $_POST['specification'];
        $rdt_under_tests = $_POST['rdt_under_tests'];
        $rdt_under_pos = $_POST['rdt_under_positive'];
        $rdt_btwn_tests = $_POST['rdt_to_tests'];
        $rdt_btwn_pos = $_POST['rdt_to_positive'];
        $rdt_over_tests = $_POST['rdt_over_tests'];
        $rdt_over_pos = $_POST['rdt_over_positive'];
        $micro_under_tests = $_POST['micro_under_tests'];
        $micro_under_pos = $_POST['micro_under_positive'];
        $micro_btwn_tests = $_POST['micro_to_tests'];
        $micro_btwn_pos = $_POST['micro_to_positive'];
        $micro_over_tests = $_POST['micro_over_tests'];
        $micro_over_pos = $_POST['micro_over_positive'];
        $beg_date = $_POST['begin_date'];
        $end_date = $_POST['end_date'];
        $explanation = $_POST['explanation'];
        $compiled_by = $_POST['compiled_by'];
        $moh_642 = $_POST['moh_642'];
        $moh_643 = $_POST['moh_643'];

        date_default_timezone_set('EUROPE/Moscow');
        $beg_date = date('Y-m-d', strtotime("first day of previous month"));
        $end_date = date('Y-m-d', strtotime("last day of previous month"));

        $user_id = $this->session->userdata('user_id');




        //date_default_timezone_set('EUROPE/Moscow');

        $order_date = date('y-m-d');
        $count = 1;

        // if($count==1) 
        // 	{
        $data = array('facility_code' => $facility_code,
            'district_id' => $district_id,
            'compiled_by' => $compiled_by,
            'order_date' => $order_date,
            'vct' => $vct,
            'pitc' => $pitc,
            'pmtct' => $pmtct,
            'b_screening' => $b_screening,
            'other' => $other,
            'specification' => $specification,
            'rdt_under_tests' => $rdt_under_tests,
            'rdt_under_pos' => $rdt_under_pos,
            'rdt_btwn_tests' => $rdt_btwn_tests,
            'rdt_btwn_pos' => $rdt_btwn_pos,
            'rdt_over_tests' => $rdt_over_tests,
            'rdt_over_pos' => $rdt_over_pos,
            'micro_under_tests' => $micro_under_tests,
            'micro_under_pos' => $micro_under_pos,
            'micro_btwn_tests' => $micro_btwn_tests,
            'micro_btwn_pos' => $micro_btwn_pos,
            'micro_over_tests' => $micro_over_tests,
            'micro_over_pos' => $micro_over_pos,
            'beg_date' => $beg_date,
            'end_date' => $end_date,
            'explanation' => $explanation,
            'moh_642' => $moh_642,
            'moh_643' => $moh_643);
        $u = new Lab_Commodity_Orders();
        $u->fromArray($data);
        $u->save();

        $lastId = Lab_Commodity_Orders::get_new_order($facility_code);
        $new_order_id = $lastId->maxId;
        $count++;


        for ($i = 0; $i < $commodity_count; $i++) {

            // if(isset($facility_code[$i])&&$facility_code[$i]!=''){

            $mydata = array(
                'order_id' => $new_order_id,
                'facility_code' => $facility_code,
                'district_id' => $district_id,
                'commodity_id' => $drug_id[$i],
                'unit_of_issue' => $unit_of_issue[$i],
                'beginning_bal' => $b_balance[$i],
                'q_received' => $q_received[$i],
                'q_used' => $q_used[$i],
                'no_of_tests_done' => $tests_done[$i],
                'losses' => $losses[$i],
                'positive_adj' => $pos_adj[$i],
                'negative_adj' => $neg_adj[$i],
                'closing_stock' => $physical_count[$i],
                'q_expiring' => $q_expiring[$i],
                'days_out_of_stock' => $days_out_of_stock[$i],
                'q_requested' => $q_requested[$i]);


            Lab_Commodity_Details::save_lab_commodities($mydata);
//            
            // }
        }
        // }
        // 	$report_type='lab';
        // 	$data='Your details have been saved.';
        // $this->get_report($report_type, $data);
        $district = $this->session->userdata('district1');
        $data['facilities'] = Facilities::get_total_facilities_rtk_in_district($district);
        $facilities = Facilities::get_total_facilities_rtk_in_district($district);
        // $facilities=Facilities::get_facility_details(6);
        $table_body = '';
        foreach ($facilities as $facility_detail) {

            date_default_timezone_set("EUROPE/Moscow");
            $lastmonth = date('F', strtotime("last day of previous month"));

            $table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='" . base_url() . "rtk_management/get_rtk_facility_detail/$facility_detail[facility_code]' href='#'>" . $facility_detail["facility_code"] . "</td>";
            $table_body .="<td>" . $facility_detail['facility_name'] . "</td><td>" . $facility_detail['facility_owner'] . "</td>";
            $table_body .="<td>";

            $lab_count = lab_commodity_orders::get_recent_lab_orders($facility_detail['facility_code']);
            $fcdrr_count = rtk_fcdrr_order_details::get_facility_order_count($facility_detail['facility_code']);
            if ($fcdrr_count > 0) {
                $table_body .="<!-- FCDRR <img src='" . base_url() . "/Images/check_mark_resize.png'></img>
                        <a href=" . site_url('rtk_management/update_fcdrr_test/' . $facility_detail['facility_code']) . " class='link'>Edit</a>|-->";
            } else {
                $table_body .="<!--<a href=" . site_url('rtk_management/fcdrr_test/' . $facility_detail['facility_code']) . " class='link'>FCDRR</a>|-->";
            }

            if ($lab_count > 0) {
                //".site_url('rtk_management/get_report/'.$facility_detail['facility_code'])."
                $table_body .="<span class='label label-success'>Submitted  for    $lastmonth </span> <!--<img src='" . base_url() . "/Images/check_mark_resize.png'></img>--><a href=" . site_url('rtk_management/rtk_orders') . " class='link'>View</a></td>";
            } else {
                $table_body .="<span class='label label-important'>  Pending for $lastmonth </span> <a href=" . site_url('rtk_management/get_report/' . $facility_detail['facility_code']) . " class='link'>Report</a></td>";
            }

            $table_body .="</td>";
        }

        $data['table_body'] = $table_body;
        $data['title'] = "Home";
        $data['popout'] = "Your order has been saved.";
        $data['content_view'] = "rtk/dpp/dpp_home_with_table";
        $data['banner_text'] = "Home";
        $data['link'] = "home";
        $this->load->view('template', $data);
//        $this->generate_lastpdf();
        // redirect('home_controller');
    }

    public function edit_lab_order_details($order_id, $msg = NULL) {
        $delivery = $this->uri->segment(3);
        $district = $this->session->userdata('district1');
        $data['title'] = "Lab Commodity Order Details";
        // $data['content_view'] = "rtk/lab_order_details_v";
        //     ini_set('memory_limit', '-1');

        $data['order_id'] = $order_id;
        $data['content_view'] = "rtk/dpp/lab_commodities_report_edit_v";
        $data['banner_text'] = "Lab Commodity Order Details";
        $data['lab_categories'] = Lab_Commodity_Categories::get_all();
        $data['detail_list'] = Lab_Commodity_Details::get_order($order_id);
        $this->load->database();
        $result = $this->db->query('SELECT * 
FROM lab_commodity_details, counties, facilities, districts, lab_commodity_orders, lab_commodity_categories, lab_commodities
WHERE lab_commodity_details.facility_code = facilities.facility_code
AND counties.id = districts.county
AND facilities.facility_code = lab_commodity_orders.facility_code
AND lab_commodity_details.commodity_id = lab_commodities.id
AND lab_commodity_categories.id = lab_commodities.category
AND facilities.district = districts.id
AND lab_commodity_details.order_id = lab_commodity_orders.id
AND lab_commodity_orders.id = ' . $order_id . '');
        $data['all_details'] = $result->result_array();

//        $data['all_details'] = Lab_Commodity_Orders::get_single_lab_order($order_id);
        $this->load->view("template", $data);
    }

    public function get_lab_report($order_no, $report_type) {
        $table_head = '<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#D8D8D8;}</style></table>
<table class="data-table" width="100%">
<thead>
<tr>
<th><strong>Category</strong></th>
	<th><strong>Description</strong></th>
	<th><strong>Unit of Issue</strong></th>
	<th><strong>Beginning Balance</strong></th>
	<th><strong>Quantity Received</strong></th>
	<th><strong>Quantity Used</strong></th>
	<th><strong>Number of Tests Done</strong></th>
	<th><strong>Losses</strong></th>
	<th><strong>Positive Adjustments</strong></th>
	<th><strong>Negative Adjustments</strong></th>
	<th><strong>Closing Stock</strong></th>
	<th><strong>Quantity Expiring in 6 Months</strong></th>
	<th><strong>Days Out of Stock</strong></th>
	<th><strong>Quantity Requested</strong></th>
</tr>
</thead>
<tbody>';
        $detail_list = Lab_Commodity_Details::get_order($order_no);
        $table_body = '';
        foreach ($detail_list as $detail) {
            $table_body.='<tr><td>' . $detail['category_name'] . '</td>';
            $table_body.='<td>' . $detail['commodity_name'] . '</td>';
            $table_body.='<td>' . $detail['unit_of_issue'] . '</td>';
            $table_body.='<td>' . $detail['beginning_bal'] . '</td>';
            $table_body.='<td>' . $detail['q_received'] . '</td>';
            $table_body.='<td>' . $detail['q_used'] . '</td>';
            $table_body.='<td>' . $detail['no_of_tests_done'] . '</td>';
            $table_body.='<td>' . $detail['losses'] . '</td>';
            $table_body.='<td>' . $detail['positive_adj'] . '</td>';
            $table_body.='<td>' . $detail['negative_adj'] . '</td>';
            $table_body.='<td>' . $detail['closing_stock'] . '</td>';
            $table_body.='<td>' . $detail['q_expiring'] . '</td>';
            $table_body.='<td>' . $detail['days_out_of_stock'] . '</td>';
            $table_body.='<td>' . $detail['q_requested'] . '</td></tr>';
        }
        $table_foot = '</tbody></table>';
        $report_name = "Lab Commodities Order " . $order_no . " Details";
        $title = "Lab Commodities Order " . $order_no . " Details";
        $html_data = $table_head . $table_body . $table_foot;

        switch ($report_type) {
            case 'excel':
                $this->generate_lab_report_excel($report_name, $title, $html_data);
                break;
            case 'pdf':
                $this->generate_lab_report_pdf($report_name, $title, $html_data);
                break;
        }
    }

//generate pdf
    public function generate_lab_report_pdf($report_name, $title, $html_data) {

        /*         * ******************************************setting the report title******************** */

        $html_title = "<div ALIGN=CENTER><img src='" . base_url() . "Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-size: 14px;display: block;font-weight: bold;'>$title</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
       Ministry of Health</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div><hr />";

        /*         * ********************************initializing the report ********************* */
        $this->load->library('mpdf');
        $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
        $this->mpdf->SetTitle($title);
        $this->mpdf->WriteHTML($html_title);
        $this->mpdf->simpleTables = true;
        $this->mpdf->WriteHTML('<br/>');
        $this->mpdf->WriteHTML($html_data);
        $report_name = $report_name . ".pdf";
        $this->mpdf->Output($report_name, 'D');
    }

    public function generate_lab_report_excel($report_name, $title, $html_data) {
        $data = $html_data;
        $filename = $report_name;
        header("Content-type: application/excel");
        header("Content-Disposition: attachment; filename=$filename.xls");
        echo "$data";
    }

    public static function get_rtk_commodities() {
        /* $query = Doctrine_Query::create() -> select("*") -> from("rtk_commodities")-> OrderBy("id asc");
          $commodities = $query -> execute();
          return $commodities;
          WHERE id =1
         */
        $commodities = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
SELECT id, commodity_code, commodity_name, unit_of_issue FROM `rtk_commodities` order by id");
        //$comm = array($commodities);
    }

    public function fcdrr_test($facility_c) {
        $data = array();

        $data['title'] = "FCDRR";
        $data['banner_text'] = "FCDRR";
        $data['content_view'] = "rtk/dpp/fcdrr_test";
        $district = $this->session->userdata('district1');
        $data['facilities'] = Facilities::get_facility_details($district);
        $data['commodities'] = Rtk_Categories::get_all();
        $data['details'] = Facilities::get_one_facility_details($facility_c);

        $this->facility_code = $facility_c;
        $data['facility_code'] = $this->facility_code;

        $this->load->view("template", $data);
    }

    public function post_fcdrr() {
        date_default_timezone_set('EUROPE/Moscow');
        $facility_c = $this->session->userdata('news');
        $order_date = date('Y-m-d');
        $facility_code = $_POST['facility_code'];
        $begin_date = $_POST['begin_date'];
        $end_date = $_POST['end_date'];
        $commodity_id = $_POST['commodity_id'];
        $beginning_balance = $_POST['beginning_bal'];
        $warehouse_quantity_received = $_POST['qty_warehouse'];
        $warehouse_lot_no = $_POST['lot_No_warehouse'];
        $other_quantity_received = $_POST['qty_other'];
        $other_lot_no = $_POST['lot_No_other'];
        $quantity_used = $_POST['qty_used'];
        $loss = $_POST['loss'];
        $positive_adj = $_POST['positive_adj'];
        $negative_adj = $_POST['negative_adj'];
        $physical_count = $_POST['ending_bal'];
        $quantity_requested = $_POST['qty_requested'];


        for ($i = 0; $i < count($commodity_id); $i++) {

            $mydata = array(
                'facility_code' => $facility_code,
                'order_date' => $order_date,
                'begin_date' => $begin_date,
                'end_date' => $end_date,
                'commodity_id' => $commodity_id[$i],
                'beginning_balance' => $beginning_balance[$i],
                'warehouse_quantity_received' => $warehouse_quantity_received[$i],
                'warehouse_lot_no' => $warehouse_lot_no[$i],
                'other_quantity_received' => $other_quantity_received[$i],
                'other_lot_no' => $other_lot_no[$i],
                'quantity_used' => $quantity_used[$i],
                'loss' => $loss[$i],
                'positive_adj' => $positive_adj[$i],
                'negative_adj' => $negative_adj[$i],
                'physical_count' => $physical_count[$i],
                'quantity_requested' => $quantity_requested[$i]);
            Rtk_Fcdrr_Order_Details::save_rtk_commodities($mydata);
        }
    }

    public function get_reporting_rate() {
        $counties = Counties::getAll();


        $national_reporting = rtk_stock_status::get_reporting_rate_national();


        $table_body = '';

        foreach ($counties as $county_detail) {
            $id = $county_detail->id;
            $table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='get_rtk_county_detail/$id' href='#'> $county_detail->county </a></td>";

            $county_detail = rtk_stock_status::get_reporting_county($id);

            $table_body .="<td>" . $county_detail[0]['total_facilities'] . "</td><td>" . $county_detail[0]['reported'] . "</td>";

            $table_body .="</tr>";
        }

        //$national_reporting=rtk_stock_status::get_reporting_rate_national();

        $table_body .="<tr><td>TOTAL</td><td>" . $national_reporting[0]['total_facilities'] . "</td><td>" . $national_reporting[0]['reported'] . "</td></tr>";



        $data['table_body'] = $table_body;
        $this->load->view("rtk/ajax_view/rtk_reporting_rate_v", $data);
    }

/////////////////////////////////////////////charts////////////////////////////////////////////////////////
    public function get_rtk_distribution_allocation($commodity) {
        $distribution_allocation_data = rtk_stock_status::get_rtk_alloaction_distribution($commodity);

        if ($commodity == "1") {
            $title = "Rapid HIV 1+ 2 Test Kit  (Unigold)";
        } else {
            $title = "Rapid HIV 1+2 Test Kit (Determine)";
        }

        $chart = '<chart decimals="0" sDecimals="0" baseFontSize="12"  showLegend="1" caption="' . $title . '"  palette="3"numdivlines="3" useRoundEdges="1" showsum="0" bgColor="FFFFFF" showBorder="0" exportEnabled="1" exportHandler="' . base_url() . 'scripts/FusionCharts/ExportHandlers/PHP/FCExporter.php" exportAtClient="0" exportAction="download">';
        $chart_categories = "<categories>";
        $chart_xml_body_qty_requested = "";
        $chart_xml_body_qty_distributed = "";
        $chart_xml_body_qty_allocated = "";

        foreach ($distribution_allocation_data as $data) {

            $chart_categories .="<category label='$data[county]'/>";
            $chart_xml_body_qty_requested.='<set  value="' . $data['qty_requested'] . '" />';
            $chart_xml_body_qty_distributed.='<set  value="' . $data['distributed'] . '" />';
            $chart_xml_body_qty_allocated.='<set  value="' . $data['allocated'] . '" />';
        }
        $chart_categories .="</categories>";


        $chart .=$chart_categories . '<dataset>
	 <dataset seriesName="Requested Quantities"> 
	 ' . $chart_xml_body_qty_requested . '
 </dataset>
 </dataset>
 <dataset>
  <dataset seriesName="Distributed Quantities"> 
	 ' . $chart_xml_body_qty_distributed . '
 </dataset>
 </dataset>
 <dataset>
  <dataset seriesName="Allocated Quantities"> 
	 ' . $chart_xml_body_qty_allocated . '
 </dataset>
	</dataset></chart>';

        echo $chart;
    }

    public function get_reporting_rate_national_doghnut($option, $county_id = NULL) {
        $str_xml_body = '';
        $title = "";
        if ($option == "county") {
            $county_name = Counties::get_county_name($county_id);
            $county_data = rtk_stock_status::get_reporting_county($county_id);
            $county_name = $county_name[0]['county'];
            $title = "$county_name";
            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities' alpha='60'/>";
                $str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities' alpha='60'/>";
            }
        } else {
            $title = 'Country wide';
            $str_xml_body = '';
            $county_data = rtk_stock_status::get_reporting_rate_national();

            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities' alpha='60'/>";
                $str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities' alpha='60'/>";
            }
        }

        $strXML = "<chart formatNumber='1' caption='Facility Reporting Rate: $title' bgColor='FFFFFF' showPercentageValues='1' showborder='0'   isSmartLineSlanted='0' showValues='1' showLabels='1' showLegend='1'>";
        $strXML .="$str_xml_body</chart>";
        echo $strXML;
    }

/////////////////////////////////////////////////////////////////////////
    public function facility_ownership_doghnut($option, $county_id = null) {
        $str_xml_body = '';
        $title = "";
        if ($option == "county") {
            $county_name = Counties::get_county_name($county_id);
            $county_data = Facilities::get_total_facilities_rtk_ownership_in_a_county($county_id);
            $county_name = $county_name[0]['county'];
            $title = "$county_name";
            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]' alpha='60'/>";
            }
        } else {
            $title = 'Country wide';
            $str_xml_body = '';
            $county_data = Facilities::get_total_facilities_rtk_ownership_in_the_country();

            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]' alpha='60'/>";
            }
        }

        $strXML = "<chart formatNumber='1' caption='Facility Ownership: $title' bgColor='FFFFFF' showPercentageValues='1' showborder='0'   isSmartLineSlanted='0' showValues='1' showLabels='1' showLegend='1'>";
        $strXML .="$str_xml_body</chart>";
        echo $strXML;
    }

    public function facility_ownership_bar_chart($option, $county_id = null) {
        $str_xml_body = '';
        $title = "";
        if ($option == "county") {
            $county_name = Counties::get_county_name($county_id);
            $county_data = Facilities::get_total_facilities_rtk_ownership_in_a_county($county_id);
            $county_name = $county_name[0]['county'];
            $title = "$county_name";
            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]'/> ";
            }
        } else {
            $title = 'Country wide';
            $str_xml_body = '';
            $county_data = Facilities::get_total_facilities_rtk_ownership_in_the_country();

            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]'/> ";
            }
        }
        $strXML = "<chart caption='Facility Ownership : $title' yAxisName='Number of facilities' xAxisName='Owner' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>";


        $strXML .="$str_xml_body</chart>";

        echo $strXML;
    }

    public function facility_ownership_combined_bar_chart() {

        $color_array['baseline'] = array('659EC7', 'E8E8E8');
        $color_array['midterm'] = array('FBB117', 'E8E8E8');
        $color_array['endterm'] = array('59E817', 'E8E8E8');

        $chart = '<chart decimals="0" sDecimals="0" slantLabels="0" baseFontSize="10" stack100Percent="1" showPercentValues="1" caption="RTK Allocation per County"  showLegend="1"palette="3"numdivlines="3" useRoundEdges="1" showsum="0" bgColor="FFFFFF" showBorder="0" exportEnabled="1" exportHandler="' . base_url() . 'scripts/FusionCharts/ExportHandlers/PHP/FCExporter.php" exportAtClient="0" exportAction="download">';
        $chart_categories = "<categories>";
        $chart_xml_body_total_facilities_with_trk = "";
        $chart_xml_body_total_facilities_without_rtk = "";

        $counties = Counties::getAll();

        foreach ($counties as $county_detail) {
            $chart_categories .= "<category label='$county_detail->county'/>";

            $county_data = facilities::get_total_facilities_rtk($county_detail->id);

            $total_no_facilities = $county_data[0]['total_facilities'];
            $total_no_allocated_rtk = $county_data[0]['total_rtk'];
            $balance = $total_no_facilities - $total_no_allocated_rtk;

            $chart_xml_body_total_facilities_with_trk .='<set  value="' . $total_no_allocated_rtk . '" />';
            $chart_xml_body_total_facilities_without_rtk .='<set  value="' . $balance . '" />';
        }
        $chart_categories .="</categories>";
        $chart .=$chart_categories . '<dataset>
	  <dataset seriesName="Allocated RTK" color="' . $color_array['baseline'][0] . '"> 
	  ' . $chart_xml_body_total_facilities_with_trk . '
 </dataset>
 ' . '<dataset showValues="0" color="' . $color_array['baseline'][1] . '">
 ' . $chart_xml_body_total_facilities_without_rtk . '</dataset>
 </dataset></chart>';

        echo $chart;
    }

    public static function update_lab_commodity_orders() {
        $order_id = $_POST['order_id'];
        $detail_id = $_POST['detail_id'];
        $district_id = $_POST['district'];
        $facility_code = $_POST['facility_code'];
        $drug_id = $_POST['commodity_id'];
        $unit_of_issue = $_POST['unit_of_issue'];
        $b_balance = $_POST['b_balance'];
        $q_received = $_POST['q_received'];
        $q_used = $_POST['q_used'];
        $tests_done = $_POST['tests_done'];
        $losses = $_POST['losses'];
        $pos_adj = $_POST['pos_adj'];
        $neg_adj = $_POST['neg_adj'];
        $physical_count = $_POST['physical_count'];
        $q_expiring = $_POST['q_expiring'];
        $days_out_of_stock = $_POST['days_out_of_stock'];
        $q_requested = $_POST['q_requested'];
        $commodity_count = count($drug_id);
        $detail_count = count($detail_id);

        $vct = $_POST['vct'];
        $pitc = $_POST['pitc'];
        $pmtct = $_POST['pmtct'];
        $b_screening = $_POST['blood_screening'];
        $other = $_POST['other2'];
        $specification = $_POST['specification'];
        $rdt_under_tests = $_POST['rdt_under_tests'];
        $rdt_under_pos = $_POST['rdt_under_positive'];
        $rdt_btwn_tests = $_POST['rdt_to_tests'];
        $rdt_btwn_pos = $_POST['rdt_to_positive'];
        $rdt_over_tests = $_POST['rdt_over_tests'];
        $rdt_over_pos = $_POST['rdt_over_positive'];
        $micro_under_tests = $_POST['micro_under_tests'];
        $micro_under_pos = $_POST['micro_under_positive'];
        $micro_btwn_tests = $_POST['micro_to_tests'];
        $micro_btwn_pos = $_POST['micro_to_positive'];
        $micro_over_tests = $_POST['micro_over_tests'];
        $micro_over_pos = $_POST['micro_over_positive'];
        date_default_timezone_set('EUROPE/Moscow');
        $beg_date = date('y-m-d', strtotime($_POST['begin_date']));
        $end_date = date('y-m-d', strtotime($_POST['end_date']));
        $explanation = $_POST['explanation'];
        $moh_642 = $_POST['moh_642'];
        $moh_643 = $_POST['moh_643'];

        $myobj = Doctrine::getTable('Lab_Commodity_Orders')->find($order_id);

        $myobj->vct = $vct;
        $myobj->pitc = $pitc;
        $myobj->pmtct = $pmtct;
        $myobj->b_screening = $b_screening;
        $myobj->other = $other;
        $myobj->specification = $specification;
        $myobj->rdt_under_tests = $rdt_under_tests;
        $myobj->rdt_under_pos = $rdt_under_pos;
        $myobj->rdt_btwn_tests = $rdt_btwn_tests;
        $myobj->rdt_btwn_pos = $rdt_btwn_pos;
        $myobj->rdt_over_tests = $rdt_over_tests;
        $myobj->rdt_over_pos = $rdt_over_pos;
        $myobj->micro_under_tests = $micro_under_tests;
        $myobj->micro_under_pos = $micro_under_pos;
        $myobj->micro_btwn_tests = $micro_btwn_tests;
        $myobj->micro_btwn_pos = $micro_btwn_pos;
        $myobj->micro_over_tests = $micro_over_tests;
        $myobj->micro_over_pos = $micro_over_pos;
        $myobj->beg_date = $beg_date;
        $myobj->end_date = $end_date;
        $myobj->explanation = $explanation;
        $myobj->moh_642 = $moh_642;
        $myobj->moh_643 = $moh_643;
        $myobj->save();


        for ($i = 0; $i < $detail_count; $i++) {
            $myobj = Doctrine::getTable('Lab_Commodity_Details')->find($detail_id[$i]);
            $myobj->beginning_bal = $b_balance[$i];
            $myobj->q_received = $q_received[$i];
            $myobj->q_used = $q_used[$i];
            $myobj->no_of_tests_done = $tests_done[$i];
            $myobj->losses = $losses[$i];
            $myobj->positive_adj = $pos_adj[$i];
            $myobj->negative_adj = $neg_adj[$i];
            $myobj->closing_stock = $physical_count[$i];
            $myobj->q_expiring = $q_expiring[$i];
            $myobj->days_out_of_stock = $days_out_of_stock[$i];
            $myobj->q_requested = $q_requested[$i];
            $myobj->save();
        }
        // 	Need to change
        // 		$district=$this->session->userdata('district1');
        //    $district_name=Districts::get_district_name($district)->toArray();
        //    $d_name=$district_name[0]['district'];
        // $data['title'] = "District Orders";
        // $data['content_view'] = "rtk/dpp/rtk_orders_listing_v";
        // $data['banner_text'] = $d_name." District Orders";		
        // $data['fcdrr_order_list']=Lab_Commodity_Orders::get_district_orders($district);
        // $data['lab_order_list']=Lab_Commodity_Orders::get_district_orders($district);
        // // dd($data['lab_order_list']);
        // $data['all_orders']=Lab_Commodity_Orders::get_district_orders($district);
        // $myobj = Doctrine::getTable('districts')->find($district);
        // //$data['district_incharge']=array($id=>$myobj->district);
        // $data['myClass'] = $this;
        // $data['msg']=$msg;
        // $this -> load -> view("template", $data);
    }

    public function lab_order_details($order_id, $msg = NULL) {
        $delivery = $this->uri->segment(3);
        $district = $this->session->userdata('district1');
        $data['title'] = "Lab Commodity Order Details";
        // $data['content_view'] = "rtk/lab_order_details_v";
        $data['order_id'] = $order_id;
        $data['content_view'] = "rtk/dpp/lab_commodities_report";
        $data['banner_text'] = "Lab Commodity Order Details";


        $data['lab_categories'] = Lab_Commodity_Categories::get_all();
        $data['detail_list'] = Lab_Commodity_Details::get_order($order_id);

        $this->load->database();
        $result = $this->db->query('SELECT * 
FROM lab_commodity_details, counties, facilities, districts, lab_commodity_orders, lab_commodity_categories, lab_commodities
WHERE lab_commodity_details.facility_code = facilities.facility_code
AND counties.id = districts.county
AND facilities.facility_code = lab_commodity_orders.facility_code
AND lab_commodity_details.commodity_id = lab_commodities.id
AND lab_commodity_categories.id = lab_commodities.category
AND facilities.district = districts.id
AND lab_commodity_details.order_id = lab_commodity_orders.id
AND lab_commodity_orders.id = ' . $order_id . '');
        $data['all_details'] = $result->result_array();

        //       $data['all_details'] = Lab_Commodity_Orders::get_single_lab_order($order_id);// shida iko hapa



        $this->load->view("template", $data);
    }

    public static function get_single_lab_order($order_id = 1) {
        $query = Doctrine_Manager::getInstance()->getCurrentConnection()
                ->fetchAll("SELECT o.id, f.facility_name, o.facility_code, o.district_id, dist.district as district_name, c.county as county_name, f.owner, cat.category_name, com.commodity_name, o.order_date, o.vct, o.pitc, o.pmtct, o.b_screening, o.other, o.specification, o.rdt_under_tests, o.rdt_under_pos, o.rdt_btwn_tests, o.rdt_btwn_pos, o.rdt_over_tests, o.rdt_over_pos, o.micro_under_tests, o.micro_under_pos, o.micro_btwn_tests, o.micro_btwn_pos, o.micro_over_tests, o.micro_over_pos, o.beg_date, o.end_date, o.explanation, o.moh_642, o.moh_643, o.compiled_by, u.fname, u.lname, d.order_id,d.facility_code,d.district_id,d.commodity_id,d.unit_of_issue,d.beginning_bal,d.q_received,d.q_used,d.no_of_tests_done,d.losses,d.positive_adj,d.negative_adj,d.closing_stock,d.q_expiring,d.days_out_of_stock,d.q_requested
		FROM lab_commodity_orders o, lab_commodity_details d,lab_commodity_categories cat, lab_commodities com, user u, facilities f, districts dist, counties c
		WHERE o.id=$order_id
		AND o.id=d.order_id
		AND o.district_id=dist.id
		AND dist.county=c.id
		AND o.facility_code=d.facility_code
		AND f.facility_code=o.facility_code
		AND u.id=o.compiled_by
		AND com.id=d.commodity_id
		AND cat.id=com.category
		ORDER BY d.commodity_id
		");
        dd($query);
    }

    public function rtk_orders($msg = NULL) {
        $district = $this->session->userdata('district1');
        $district_name = Districts::get_district_name($district)->toArray();
        $d_name = $district_name[0]['district'];

        $data['title'] = "District Orders";
        $data['content_view'] = "rtk/dpp/rtk_orders_listing_v";
        $data['banner_text'] = $d_name . " District Orders";
//        $data['fcdrr_order_list'] = Lab_Commodity_Orders::get_district_orders($district);
        $data['lab_order_list'] = Lab_Commodity_Orders::get_district_orders($district);
        ini_set('memory_limit', '-1');
        $this->load->database();
        $query = $this->db->query('SELECT  
        facilities.facility_code,facilities.facility_name,lab_commodity_orders.id,lab_commodity_orders.order_date,lab_commodity_orders.district_id,lab_commodity_orders.compiled_by,lab_commodity_orders.facility_code
                FROM lab_commodity_orders, facilities
                WHERE lab_commodity_orders.facility_code = facilities.facility_code 
                AND lab_commodity_orders.district_id ='.$district.'');
        $data['lab_order_list'] = $query->result_array();
  //      echo "<pre>";
//      var_dump($data['lab_order_list']);
    //  echo "</pre>";


        $data['all_orders'] = Lab_Commodity_Orders::get_district_orders($district);
        $myobj = Doctrine::getTable('districts')->find($district);
        //$data['district_incharge']=array($id=>$myobj->district);
        $data['myClass'] = $this;
        $data['msg'] = $msg;

    $this->load->view("template", $data);
    }

    public function get_reporting_rate_national_bar($option, $county_id = NULL) {
        $str_xml_body = '';
        $title = "";
        if ($option == "county") {
            $county_name = Counties::get_county_name($county_id);
            $county_data = rtk_stock_status::get_reporting_county($county_id);
            $county_name = $county_name[0]['county'];
            $title = "$county_name";
            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities'/>";
                $str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities'/>";
            }
        } else {
            $title = 'Country wide';
            $str_xml_body = '';
            $county_data = rtk_stock_status::get_reporting_rate_national();

            foreach ($county_data as $county_detail) {
                $str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities' />";
                $str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities' />";
            }
        }

        $strXML = "<chart caption='Facility Reporting Rate : $title' yAxisName='Number of facilities' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>";
        $strXML .="$str_xml_body</chart>";
        echo $strXML;
    }

    public function facility_reporting_combined_bar_chart() {

        $color_array['baseline'] = array('659EC7', 'E8E8E8');
        $color_array['midterm'] = array('FBB117', 'E8E8E8');
        $color_array['endterm'] = array('59E817', 'E8E8E8');

        $chart = '<chart decimals="0" sDecimals="0" slantLabels="0" baseFontSize="10" stack100Percent="1" showPercentValues="1" caption="RTK Allocation per County"  showLegend="1"palette="3"numdivlines="3" useRoundEdges="1" showsum="0" bgColor="FFFFFF" showBorder="0" exportEnabled="1" exportHandler="' . base_url() . 'scripts/FusionCharts/ExportHandlers/PHP/FCExporter.php" exportAtClient="0" exportAction="download">';
        $chart_categories = "<categories>";
        $chart_xml_body_total_facilities_with_trk = "";
        $chart_xml_body_total_facilities_without_rtk = "";

        $counties = Counties::getAll();

        foreach ($counties as $county_detail) {
            $chart_categories .= "<category label='$county_detail->county'/>";

            $county_data = rtk_stock_status::get_reporting_county($county_detail->id);

            $total_no_facilities = $county_data[0]['total_facilities'];
            $total_no_allocated_rtk = $county_data[0]['reported'];
            $balance = $total_no_facilities - $total_no_allocated_rtk;

            $chart_xml_body_total_facilities_with_trk .='<set  value="' . $total_no_allocated_rtk . '" />';
            $chart_xml_body_total_facilities_without_rtk .='<set  value="' . $balance . '" />';
        }
        $chart_categories .="</categories>";
        $chart .=$chart_categories . '<dataset>
	  <dataset seriesName="Reported" color="' . $color_array['baseline'][0] . '"> 
	  ' . $chart_xml_body_total_facilities_with_trk . '
 </dataset>
 ' . '<dataset showValues="0" color="' . $color_array['baseline'][1] . '">
 ' . $chart_xml_body_total_facilities_without_rtk . '</dataset>
 </dataset></chart>';

        echo $chart;
    }

    public function kenya_county_map() {

        $colors = array("FFFFCC" => "1", "E2E2C7" => "2", "FFCCFF" => "3", "F7F7F7" => "5", "FFCC99" => "6", "B3D7FF" => "7", "CBCB96" => "8", "FFCCCC" => "9");

        $counties = Counties::get_county_map_data();
        $map = "";
        foreach ($counties as $county_detail) {

            $countyid = $county_detail->id;
            $county_map_id = $county_detail->kenya_map_id;
            $countyname = trim($county_detail->county);

            $county_detail = rtk_stock_status::get_reporting_county($countyid);
            $total_facilities = $county_detail[0]['total_facilities'];
            $reporting_facilities = $county_detail[0]['reported'];



            $reporting_rate = round((($reporting_facilities / $total_facilities) * 100), 1);
            $map .="<entity  link='rtk_management/county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='" . array_rand($colors, 1) . "'  toolText='County :$countyname&lt;BR&gt; Total Facilities :" . $total_facilities . "&lt;BR&gt; Facilities Reporting  :" . $reporting_facilities . "&lt;BR&gt; Facility Reporting Rate :" . $reporting_rate . " %'/>";
        }
        echo $this->kenyan_map($map);
    }

    public function rtk_allocation_kenyan_map() {
        $colors = array("FFFFCC" => "1", "E2E2C7" => "2", "FFCCFF" => "3", "F7F7F7" => "5", "FFCC99" => "6", "B3D7FF" => "7", "CBCB96" => "8", "FFCCCC" => "9");


        $map = "";

        $counties = Counties::get_county_map_data();
        $table_data = "";
        $allocation_rate = 0;
        $total_facilities_in_county = 1;
        $total_facilities_allocated_in_county = 1;
        foreach ($counties as $county_detail) {

            $countyid = $county_detail->id;
            $county_map_id = $county_detail->kenya_map_id;
            $countyname = trim($county_detail->county);

            $county_detail = rtk_stock_status::get_allocation_rate_county($countyid);
            $total_facilities_in_county = $county_detail['total_facilities_in_county'];
            $total_facilities_allocated_in_county = $county_detail['total_facilities_allocated_in_county'];

            @$allocation_rate = round((($total_facilities_allocated_in_county / $total_facilities_in_county) * 100), 1);
//     $map .="<entity  link='".base_url()."rtk_management/allocate_rtk/$countyid' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."' toolText='County :$countyname&lt;BR&gt; Total Facilities Reporting:".$total_facilities_in_county."&lt;BR&gt; Facilities Allocated  :".$total_facilities_allocated_in_county."&lt;BR&gt; Facility Allocation Rate :".$allocation_rate." %'/>";
            $map .="<entity  link='" . base_url() . "rtk_management/allocation_county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='" . array_rand($colors, 1) . "' toolText='County :$countyname&lt;BR&gt; Total Facilities Reporting:" . $total_facilities_in_county . "&lt;BR&gt; Facilities Allocated  :" . $total_facilities_allocated_in_county . "&lt;BR&gt; Facility Allocation Rate :" . $allocation_rate . " %'/>";
        }
        echo $this->kenyan_map($map, "RTK County allocation: Click to view facilities in county");
    }

    public function allocate_rtk($county_id) {
        $ish;
        $county = counties::get_county_name($county_id);
        foreach ($county as $cname) {
            $ish = $cname['county'];
        }
        $data ['countyname'] = $ish;



//	$facilities_in_county = facilities::get_total_facilities_rtk_in_county($county_id);
//	var_dump($facilities_in_county);

        $htm = '';

        $districts_in_county = districts::getDistrict($county_id);
//	var_dump($district);
        $htm.='<ul class="facility-list">';
        foreach ($districts_in_county as $key => $district_arr) {
            # code...
//		echo $district_arr['district'];

            $district = $district_arr['id'];
            $district_name = $district_arr['district'];
            $htm.='<li>' . $district_name . '</li>';
            $htm.='<ul class="sub-list">';
            $district_orders = Lab_Commodity_Orders::get_district_orders($district);
            if (count($district_orders) > 0) {
                foreach ($district_orders as $district_orders_arr) {
                    $facility = $district_orders_arr['facility_code'];
                    $facility_name = $district_orders_arr['facility_name'];
                    $htm.='<li style="border-left: medium solid rgb(233, 105, 88);background: #fff;"><a href="#' . $facility . '" class="allocate" onClick="showpreview(' . $facility . ')" >' . $facility_name . '</a></li>';
//			$htm .='<li><a href="#'.$facility.'" class="allocate" onClick="showpreview('.$facility.')" >'.$facilitiessarr['fname'].'</a></li>';
                }
            } else {
                $htm.='<li style="border-left: medium solid rgb(88, 233, 106);background: #fff;">No Orders</li>';
            }
            $htm.='</ul>';
        }
        $htm.='</ul>';

        $data['htm'] = $htm;
        $data['content_view'] = 'allocation_committee/ajax_view/rtk_county_allocation_v';
        $data['banner_text'] = '';
        $data['title'] = '';
        $this->load->view("template", $data);
    }

    public function kenyan_map($data, $title = NULL) {
        $map = "";
        $map .="<map showBevel='0' showMarkerLabels='1' caption='$title'  fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";

        $map .="<data>";
        $map .=$data;
        $map .="</data>
		<styles> 
  <definition>
   <style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   <style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   <style name='myShadow' type='Shadow' distance='1'/>
  </definition>
  <application>
   <apply toObject='MARKERS' styles='myShadow' /> 
   <apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
   <apply toObject='TOOLTIP' styles='TTipFont' />
  </application>
 </styles>
</map>";

        return $map;
    }

    public function get_allocation_rate_national_hlineargauge($option = NULL, $county_id = NULL) {
        $str_xml_body = '';
        $title = "RTK Allocation rate:";
        if ($option == "county") {
            $county_name = Counties::get_county_name($county_id);
            $county_data = rtk_stock_status::get_allocation_rate_county($county_id);

            $county_name = $county_name[0]['county'];
            $title = " $county_name County";

            $str_xml_body .="<value>$county_data[allocation_rate]</value>";
        } else {
            $title = ' Country wide';
            $str_xml_body = '';
            $country_data = rtk_stock_status::get_allocation_rate_national();


            $str_xml_body .="<value>$country_data</value>";
        }

        $strXML = "<Chart bgColor='FFFFFF' bgAlpha='0' numberSuffix='%' caption='$title' showBorder='0' upperLimit='100' lowerLimit='0' gaugeRoundRadius='5' chartBottomMargin='10' ticksBelowGauge='0' 
showGaugeLabels='0' valueAbovePointer='0' pointerOnTop='1' pointerRadius='9'>
    <colorRange> 
       
        <color minValue='0' maxValue='33' name='BAD' code='FF0000' />
        
        <color minValue='34' maxValue='67' name='WEAK' code='FFFF00' /> 
         <color minValue='68' maxValue='100' name='GOOD' code='00FF00' />
    </colorRange>";
        $strXML .="$str_xml_body
<styles>
        <definition>
            <style name='ValueFont' type='Font' bgColor='333333' size='10' color='FFFFFF'/>
        </definition>
        <application>
            <apply toObject='VALUE' styles='valueFont'/>
        </application>	
    </styles>
</Chart>";

        echo $strXML;
    }

    ////////////////////////////////////////end of graphs////////////////////////////////////////
    public function get_facility_ownership_bar_chart_ajax() {


        $this->load->view("county_rtk_v");
    }

    public function get_facility_ownership_doghnut_ajax() {
        $this->load->view("county_rtk_v");
    }

    public function get_kenyan_county_map() {
        $this->load->view("rtk/ajax_view/kenya_county_v");
    }

    public function county_detail_zoom($county_id) {

        $data['facility'] = Facilities::get_total_facilities_rtk_in_county($county_id);
        $data['doghnut'] = "county";
        $data['bar_chart'] = "county";
        $data['county_id'] = $county_id;
        $data['content_view'] = "rtk/ajax_view/county_detail_zoom_v";
        $data['title'] = "County View";
        $data['banner_text'] = "County View";
        $this->load->view("template", $data);
    }

    public function get_rtk_facility_detail($facility_code) {
        $county_data = rtk_stock_status::get_facility_reporting_details($facility_code);

        $table_body = '';
        $fill_rate = 0;

        if (count($county_data) > 0) {



            foreach ($county_data as $county_detail) {



                $total_requested = $county_detail['qty_requested'];
                $total_delivered = $county_detail['distributed'];
                @$fill_rate = round((($total_delivered / $total_requested) * 100), 1);
                if ($county_detail['commodity'] == 1) {
                    $commodity = "Rapid HIV 1+ 2 Test Kit  (Unigold)";
                }
                if ($county_detail['commodity'] == 2) {
                    $commodity = "Rapid HIV 1+2 Test Kit (Determine)";
                }

                if ($county_detail['commodity'] == 3) {
                    $commodity = "Rapid Syphillis Test (RPR)";
                }

                $table_body .="<tr>
	<td>$county_detail[facility_code]</td>
	<td>$county_detail[facility_name]</td>
	<td>$county_detail[owner]</td>
	<td>$commodity</td>
	<td>$county_detail[qty_requested]</td>
	<td>$county_detail[allocated]</td>
	<td>$county_detail[distributed]</td>
	<td>$fill_rate %</td>
	 </tr>";
            }
        } else {
            //do nothing 
        }

        $data['table_body'] = $table_body;
        $this->load->view("rtk/ajax_view/facility_zoom_v", $data);
    }

    public function rapid_kit_county_allocation($county_id) {
//	echo $county_id;
        $county = Counties::get_county_name($county_id);
        $county_data = rtk_stock_status::get_county_reporting_details($county_id);



        $sum_unigold = 0;
        $sum_determine = 0;
        $sum_syphillis = 0;
        foreach ($county_data as $county_detail) {
            # code...
            if ($county_detail['commodity'] == 1) {
                $commodity = "Rapid HIV 1+ 2 Test Kit  (Unigold)";
                $sum_unigold+=$county_detail['qty'];
            }
            if ($county_detail['commodity'] == 2) {
                $commodity = "Rapid HIV 1+2 Test Kit (Determine)";
                $sum_determine+=$county_detail['qty'];
            }
            if ($county_detail['commodity'] == 3) {
                $commodity = "Rapid Syphillis Test (RPR)";
                $sum_syphillis+=$county_detail['qty'];
            }
            echo "<pre>";
//	var_dump($county_data);
            echo "</pre>";
        }
        /*
          echo $sum_unigold."<br />";
          echo $sum_syphillis."<br />";
          echo $sum_determine."<br />";
         */

        // the code below builds the xmp body


        $str_xml_body = '';
        $title = "";

        $county_name = Counties::get_county_name($county_id);
        $county_data = rtk_stock_status::get_reporting_county($county_id);
        $county_name = $county_name[0]['county'];
        $title = "Rapid kit allocation by county:" . " $county_name";
        $str_xml_body .="<set value='$sum_determine' label='Total Determine'/>";
        $str_xml_body .="<set value='$sum_unigold' label='Total Unigold'/>";
        $str_xml_body .="<set value='$sum_syphillis' label='Sum Syphillis'/>";




        $strXML = "<chart caption='Facility Reporting Rate : $title' yAxisName='Number of facilities' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>";
        $strXML .="$str_xml_body</chart>";
        echo $strXML;
    }

    public function get_rtk_allocation_kenyan_map() {

        $this->load->view("allocation_committee/ajax_view/rtk_allocation_county_map");
    }

    public function allocation_county_detail_zoom($county_id) {
        $ish;
        $county = counties::get_county_name($county_id);
        foreach ($county as $cname) {
            $ish = $cname['county'];
        }
        $data ['countyname'] = $ish;



//	$facilities_in_county = facilities::get_total_facilities_rtk_in_county($county_id);
//	var_dump($facilities_in_county);

        $htm = '';
        $table_body = '';

        $districts_in_county = districts::getDistrict($county_id);
//	var_dump($district);
        $htm.='<ul class="facility-list">';
        foreach ($districts_in_county as $key => $district_arr) {
            # code...
//		echo $district_arr['district'];

            $district = $district_arr['id'];

            $district_name = $district_arr['district'];
            $htm.='<li>' . $district_name . '</li>';
            $htm.='<ul class="sub-list">';
            //          $district_orders = Lab_Commodity_Orders::get_district_orders($district);
//            var_dump($district_orders);
            $facilities = $this->db->query('SELECT * 
                        FROM  `facilities` , districts
                        WHERE districts.id = facilities.district
                        AND districts.id=' . $district . '');


//            if (count($district_orders) > 0) {
            if ($facilities->num_rows() > 0) {
                foreach ($facilities->result_array() as $district_orders_arr) {
                    $facility = $district_orders_arr['facility_code'];
                    $facility_name = $district_orders_arr['facility_name'];



                    $orders = $this->db->query('SELECT * 
						FROM  `lab_commodity_details` 
						WHERE  `facility_code` =  ' . $facility . '
						LIMIT 0 , 4');
                    if ($orders->num_rows() > 0) {
                        foreach ($orders->result_array() as $orders_arr) {
                            # code...
                            $order_detail_id = $orders_arr['id'];
                            $q_requested = $orders_arr['q_requested'];
                            $q_received = $orders_arr['q_received'];
                            $commodity_id = $orders_arr['commodity_id'];
                            $closing_stock = $orders_arr['closing_stock'];
                            $q_used = $orders_arr['q_used'];
                            $beginning_bal = $orders_arr['beginning_bal'];
                            $facility_code = $orders_arr['facility_code'];
                            $allocated = $orders_arr['allocated'];


                            if ($commodity_id == 1) {
                                $commodity = "Rapid HIV 1+2 Test 1 - Screening";
                            }
                            if ($commodity_id == 2) {
                                $commodity = "Rapid HIV 1+2 Test 1 - Confirmatory";
                            }

                            if ($commodity_id == 3) {
                                $commodity = "Rapid HIV 1+2 Test 1 - Tiebreaker";
                            }
                            if ($commodity_id == 4) {
                                $commodity = "Rapid Syphillis Test (RPR)";
                            }
                            date_default_timezone_set('Europe/Moscow');
                            $firstday = date('D dS M Y', strtotime("first day of previous month"));
                            $lastday = date('D dS M Y', strtotime("last day of previous month"));
                            $lastmonth = date('F', strtotime("last day of previous month"));
                            $allocation = '';
                            if ($allocated > 0) {
                                $allocation = '<span class="label label-success">Allocated for  ' . $lastmonth . '</span>';
                            } else {
                                $allocation = '<span class="label label-important">Pending Allocation for  ' . $lastmonth . '</span>';
                            }
                            $table_body.="
                            <tr id=''>
<input type='hidden' name='$order_detail_id' value='$order_detail_id' />

<td>$facility_code</td>
<td>$facility_name</td>
<td>$district_name</td>
<td>$commodity</td>
<td>$q_received</td>
<td>$q_used</td>
<td>$closing_stock</td>
<td>$q_requested</td>
<td><input type='text' class='user2' name='allocated_$order_detail_id' value='$allocated'/></td>
<td>$q_requested</td>
<td>$allocation</td>
</tr>";
                        }
                    }

                    $htm.='<li style="border-left: medium solid rgb(233, 105, 88);background: #fff;"><a href="#' . $facility . '" class="allocate" onClick="showpreview(' . $facility . ')" >' . $facility_name . '</a></li>';
//			$htm .='<li><a href="#'.$facility.'" class="allocate" onClick="showpreview('.$facility.')" >'.$facilitiessarr['fname'].'</a></li>';
                }
            }

            $htm.='</ul>';
        }
        $htm.='</ul>';

        $data['htm'] = $htm;
//	$data['content_view'] = 'allocation_committee/ajax_view/rtk_county_allocation_v';
        $data['county_id'] = $county_id;
        $data['table_body'] = $table_body;
        $data['title'] = "County View";
        $data['banner_text'] = "County View";
        $data['content_view'] = "allocation_committee/ajax_view/rtk_county_allocation_datatableonly_v";
        $this->load->view("template", $data);
    }

    public function allocation() {
        echo "This one";
    }

    public function rtk_allocation_data() {
        $arr = array();
        foreach ($_POST as $value) {
            //      echo($key).'<br />';
//       echo $value.'<br />';
            array_push($arr, $value);


//        echo 'UPDATE  `kemsa2`.`lab_commodity_details` SET  `allocated` =  \'34\',`allocated_date` =  \'3232\' WHERE  `lab_commodity_details`.`id` ='.$value.'';
        }
        $now = time();

        $i = 0;
        $j = 1;
        while ($i < 48 && $j < 48) {
//    echo $arr[$i].'==>'.$arr[$j].'<br />';
            $id = $arr[$i];
            $val = $arr[$j];

            $this->load->database($arr);

            $query = 'UPDATE  `kemsa2`.`lab_commodity_details` SET  `allocated` =  ' . $val . ',`allocated_date` =  ' . $now . ' WHERE  `lab_commodity_details`.`id` =' . $id . '';
            $this->db->query($query);
            $i+=2;
            $j+=2;
        }
        $this->distribution_memo($arr);


        redirect('', $msg = "allocateions saved");
    }

    public function memo() {
        $arr = '["99","12","100","21","129","12","130","12","131","34","132","43","113","6","114","21","115","43","116","43","65","65","67","5","1","0","2","0","3","0","4","0","49","0","50","0","51","0","52","0","97","0","98","0","66","0","68","4"]';
        $arr = json_decode($arr);
        $this->distribution_memo($arr);
    }

    public function distribution_memo($arr) {
        $this->load->database();
        $tdata = '';
        $i = 0;
        $j = 1;
        while ($i < 48 && $j < 48) {

            $id = $arr[$i];
            $val = $arr[$j];
            //echo 'SELECT * FROM lab_commodity_details, facilities WHERE facilities.facility_code = lab_commodity_details.facility_code    AND lab_commodity_details.id =' . $arr[$i]. '<br />';

            $allocations = $this->db->query('SELECT * FROM lab_commodity_details, facilities WHERE facilities.facility_code = lab_commodity_details.facility_code AND lab_commodity_details.id =' . $id . '');
            $allocs_array = $allocations->result_array();

            $commodity_id = $allocs_array[0]['commodity_id'];
            if ($commodity_id == 1) {
                $commodity = "Rapid HIV 1+2 Test 1 - Screening";
            }
            if ($commodity_id == 2) {
                $commodity = "Rapid HIV 1+2 Test 1 - Confirmatory";
            }
            if ($commodity_id == 3) {
                $commodity = "Rapid HIV 1+2 Test 1 - Tiebreaker";
            }
            if ($commodity_id == 4) {
                $commodity = "Rapid Syphillis Test (RPR)";
            }
            //   var_dump($allocs_array);
//             echo '<br />';
            if ($allocs_array[0]['allocated'] > 0) {
                $tdata .= '' . $allocs_array[0]['facility_name'] . ' was allocated ' . $allocs_array[0]['allocated'] . ' of ' . $commodity . '<br />';
            }
            /*            foreach ($allocations->result_array() as $allocs_array) {
              // echo "<pre>";
              // var_dump($allocs_array);
              //echo "</pre>";
              $commodity_id = $allocs_array['commodity_id'];
              if ($commodity_id == 1) {$commodity = "Rapid HIV 1+2 Test 1 - Screening";}
              if ($commodity_id == 2) {$commodity = "Rapid HIV 1+2 Test 1 - Confirmatory";}
              if ($commodity_id == 3) {$commodity = "Rapid HIV 1+2 Test 1 - Tiebreaker";}
              if ($commodity_id == 4) {$commodity = "Rapid Syphillis Test (RPR)";}
              } */

            $i+=2;
            $j+=2;
        }
//        echo $tdata;
        date_default_timezone_set('EUROPE/Moscow');
        date_default_timezone_set("EUROPE/Moscow");
        $firstday = date('D dS M Y', strtotime("first day of previous month"));
        $lastday = date('D dS M Y', strtotime("last day of previous month"));
        $lastmonth = date('F', strtotime("last day of previous month"));

        $reportname = 'RTK Allocations for ' . $lastmonth;
        $this->sendmail($tdata, $reportname);
    }

    public function allocations() {
        $data['title'] = '';
        $data['banner_text'] = '';
        $data['content_view'] = 'allocation_committee/allocations_view';
        $tdata = '';

        $this->load->database();

        $allcounties = $this->db->query('SELECT county,id FROM  `counties` ');
//        $counties_data = $allcounties->result_array();
        foreach ($allcounties->result_array() as $counties_data) {
            # code...
            $id = $counties_data['id'];
            $County = $counties_data['county'];
            $allocations = $this->db->query('SELECT * 
        FROM lab_commodity_details, counties, facilities, districts
        WHERE lab_commodity_details.facility_code = facilities.facility_code
        AND counties.id = districts.county
        AND counties.id =' . $id . '
        AND facilities.district = districts.id
        AND lab_commodity_details.allocated >0');
            foreach ($allocations->result_array() as $allocations_arr) {

                # code...
//                var_dump($allocations_arr);
//                $facilities->num_rows() > 0)
            }
            $num = $allocations->num_rows();
            if ($num > 1) {
                $tdata .= '<tr><td>' . $County . '</td><td>July</td><td>' . $num . '</td><td><a href="allocations_county/' . $id . '">View</a> </td></tr>';
            }
        }


        $data['tdata'] = $tdata;
        $this->load->view('template', $data);
    }

    public function allocations_county($county) {
        $data['title'] = '';
        $data['banner_text'] = '';
        $data['content_view'] = 'allocation_committee/counties_allocated_view';
        $tdata = '';

        $this->load->database();

        $allcounties = $this->db->query('SELECT county,id FROM  `counties` WHERE id =' . $county . ' ');
//        $counties_data = $allcounties->result_array();
        foreach ($allcounties->result_array() as $counties_data) {
            # code...
            $id = $counties_data['id'];
            $County = $counties_data['county'];
            $allocations = $this->db->query('SELECT * 
FROM lab_commodity_details, counties, facilities, districts, lab_commodity_orders
WHERE lab_commodity_details.facility_code = facilities.facility_code
AND counties.id = districts.county
AND counties.id =' . $id . '
AND facilities.district = districts.id
AND lab_commodity_details.order_id = lab_commodity_orders.id
AND lab_commodity_details.allocated >0');
            foreach ($allocations->result_array() as $allocations_arr) {
                //  echo "<pre>";
                //    var_dump($allocations_arr);
                //echo "</pre>";

                $commodity_id = $allocations_arr['commodity_id'];
                $facility_name = $allocations_arr['facility_name'];
                $district = $allocations_arr['district'];
                $facility_code = $allocations_arr['facility_code'];
                $beginning_bal = $allocations_arr['beginning_bal'];
                $closing_stock = $allocations_arr['closing_stock'];
                $month = $allocations_arr['month'];
                $q_requested = $allocations_arr['q_requested'];
                $allocated = $allocations_arr['allocated'];
                $order_id = $allocations_arr['order_id'];
                $allocations_arr['month'];

                $commodity = "";

                if ($commodity_id == 1) {
                    $commodity = "Rapid HIV 1+2 Test 1 - Screening";
                }
                if ($commodity_id == 2) {
                    $commodity = "Rapid HIV 1+2 Test 1 - Confirmatory";
                }
                if ($commodity_id == 3) {
                    $commodity = "Rapid HIV 1+2 Test 1 - Tiebreaker";
                }
                if ($commodity_id == 4) {
                    $commodity = "Rapid Syphillis Test (RPR)";
                }


                $allocations_data_commodity_id = $allocations_arr["commodity_id"];

                $tdata .= '<tr><td>' . $facility_name . '</td>
          <td>' . $facility_code . '</td>
        
          <td>' . $district . '</td>
          <td>' . $commodity . '</td>
          <td>' . $beginning_bal . '</td>
          <td>' . $closing_stock . '</td>
          <td>' . $q_requested . '</td>
          <td>' . $allocated . '</td>
         <td><a href="../lab_order_details/' . $order_id . '" title="View entire order">View</a> <br /><!--<a href="#">download</a>--></td></tr>';

//                $facilities->num_rows() > 0)
            }
        }


        $data['tdata'] = $tdata;

        $this->load->view('template', $data);
    }

    public function allocation_county_detail_zoom_old($county_id) {

        $county_data = rtk_stock_status::get_county_reporting_details($county_id);
        $county_name = Counties::get_county_name($county_id);
        $county_name = $county_name[0]['county'];
        $table_body = '';
        $fill_rate = 0;
        $checker = 0;
        if (count($county_data) > 0) {
            foreach ($county_data as $county_detail) {
                if ($county_detail['commodity'] == 1) {
                    $commodity = "Rapid HIV 1+ 2 Test Kit  (Unigold)";
                }
                if ($county_detail['commodity'] == 2) {
                    $commodity = "Rapid HIV 1+2 Test Kit (Determine)";
                }

                if ($county_detail['commodity'] == 3) {
                    $commodity = "Rapid Syphillis Test (RPR)";
                }

                $table_body .="<tr>
	<input type='hidden' name='facility_code[$checker]' value='$county_detail[facility_code]' />
	<input type='hidden' name='commodity_id[$checker]' value='$county_detail[commodity]' />
	<td>$county_detail[facility_code]</td>
	<td>$county_detail[facility_name]</td>
	<td>$county_detail[owner]</td>
	<td>$commodity</td>
	<td>$county_detail[qty_received]</td>
	<td>$county_detail[issued]</td>
	<td>$county_detail[physical_count]</td>
	<td>$county_detail[qty_requested]</td>
	<td><input type='text' class='user2' name='qty_allocated[$checker]' value='$county_detail[qty]'/></td>
	<td>$county_detail[issued]</td>
	
	
	 </tr>";

                $checker++;
            }
        } else {
            //do nothing 
        }
        $data['county_name'] = $county_name;
        $data['doghnut'] = "county";
        $data['bar_chart'] = "county";
        $data['county_id'] = $county_id;
        $data['table_body'] = $table_body;
        $data['title'] = "County View";
        $data['banner_text'] = "County View";
        $data['content_view'] = "allocation_committee/ajax_view/rtk_county_allocation_datatableonly_v";
        $this->load->view("template", $data);
    }

/////////insert functions

    public function rtk_allocation_form_data($county_id) {
        $facility_code = $_POST['facility_code'];
        $allocation_data = $_POST['qty_allocated'];
        $commodity_id = $_POST['commodity_id'];

        $date = date('y-m-d');

        foreach ($allocation_data as $key => $value) {
            if ($value > 0) {

                $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                $q->execute("insert into rtk_allocation set facility_code=$facility_code[$key],qty=$value,`date_allocated`='$date',commodity_id=$commodity_id[$key]");
            } else {
                //do nothing 
            }
        }

        $county_name = Counties::get_county_name($county_id);
        $county_name = $county_name[0]['county'];

        $this->home("Allocation Details for $county_name County has been updated");
    }

////////////////////////////////////////////////////////////////////////////////////////charts
    public function generate_malaria_test_chart() {
        $strXML = "<chart palette='1' useRoundEdges='1' xaxisname='Type of Test' yaxisname='No of Tests' bgColor='FFFFFF' showBorder='0'  caption='Malaria Tests' >
        <categories font='Arial' >
                >
                <category label='RDT' />
                <category label='Microscopy' />
                

        </categories>
        <dataset seriesname=' Patients under 5 years' color='8BBA00' >
                <set value='30' />
                <set value='26' />
                <set value='29' />
                
        </dataset>

        <dataset seriesname='Patients 5-14 yrs' color='A66EDD' >
                <set value='67' />
                <set value='98' />
                <set value='79' />
                
        </dataset>

        <dataset seriesname='Patients over 14 years' color='F6BD0F' >
                <set value='27' />
                <set value='25' />
                <set value='28' />
                
        </dataset>

</chart>";
        echo $strXML;
    }

    public function generate_hiv_test_kits_chart() {
        $strXML = "<chart caption='HIV Tests N=456' bgColor='FFFFFF' useRoundEdges='1'  showBorder='0' showPercentageValues='1' plotBorderColor='FFFFFF' isSmartLineSlanted='0' showValues='1' showLabels='1' showLegend='1'>
        <set value='212' label='VCT' />
        <set value='96' label='PITC' />
        <set value='26' label='PMTCT' />
        <set value='29' label='Blood Screening' />
        <set value='93' label='Other'/>
</chart>";

        echo $strXML;
    }

////////////////////////////////////////////////////////////////////////////////////////////
    public function fcdrr_Report() {                   //New
        $data['title'] = "FCDRR REPORT";
        //$data['drugs'] = Drug::getAll();
        $data['content_view'] = "rtk/fcdrr_Report";
        $data['banner_text'] = "FCDRR REPORT";
        $data['link'] = "rtk_management";
        $data['quick_link'] = "fcdrr_Report";
        $this->load->view("template", $data);
    }

    public function fcdrr_Report_pdf($reportType) {
        $report_name = "FCDRR_REPORT";
        $title = "FCDRR REPORT";
        $html_data1 = '';

        $html_data1 .='<table class="data-table" border=1><tbody>
			<tr><td rowspan="2"><b>COMMODITY CODE</b></td>
			<td rowspan="2"><b>COMMODITY NAME</b></td>
            <td rowspan="2"><b>UNIT OF ISSUE</b></td>
            <td rowspan="2"><b>BEGINNING BALANCE</b></td>
            <td colspan="2"><b>QUANTITY RECEIVED FROM CENTRAL<br/> WAREHOUSE (e.g. KEMSA)</b></td>             
            <td rowspan="2"><b>QUANTITY USED</b></td>
            <td rowspan="2"><b>LOSSES/WASTAGE</b></td>
            <td colspan="2"><b>ADJUSTMENTS<br/><i>Indicate if (+) or (-)</i></b></td>
            <td rowspan="2"><b>ENDING BALANCE <br/>PYSICAL COUNT at end of the Month</b></td>
            <td rowspan="2"><b>QUANTITY REQUESTED</b></td>
            </tr>
            
            
            <tr>      
             <td>Quantity</td>
            <td>Lot No.</td>
            <td>Positive</td>
            <td>Negative</td>    
            </tr>
            
            
<tr><td colspan="12"><b>FACS Calibular Reagents and Consumables</b></td></tr>

<tr>
<td>CAL 002</td>
<td>Tri-TEST CD3/CD4/CD45 with TruCOUNT Tubes</td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CAL 003</td>
<td>Calibrite 3 Beads</td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CAL 005</td>
<td>FACS Lysing solution</td>
<td>ml</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CAL 006</td>
<td>Falcon Tubes</td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr>
<td>CAL 009</td>
<td>Printing Paper</td>
<td>1 ream</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>

<tr><td>CAL 010</td>
<td>Printer Catridge</td>
<td>1</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td colspan="12"><b>FACS Count Reagents and Consumables</b></td></tr>

<tr><td>FACS 001</td>
<td>FACSCount CD4/CD3 Reagent <b>[Adult]</b></td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>FACS 002</td>
<td>FACSCount CD4 % Reagent <b>[Paediatric]</b></td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>FACS 003</td>
<td>FACSC Control kit</td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>FACS 004</td>
<td>Thermal Paper FacsCount</td>
<td>1 roll</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td colspan="12"><b>Cyflow Partec |Reagents and Consumables</b></td></tr>

<tr><td>PART 001</td>
<td>EASY Count CD4/CD3 Reagent <b>[Adult]</b></td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>PART 002</td>
<td>EASY Count CD4 % Reagent <b>[Paediatric]</b></td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td></tr>

<tr><td>PART 003</td>
<td>Control check beads></td>
<td>test</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>PART 004</td>
<td>Thermal Paper</td>
<td>1 roll</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td colspan="12"><b>Common Reagents/Consumables</b></td></tr>

<tr><td>CON 001</td>
<td>Sheath fluid</td>
<td>20L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CON 002</td>
<td>Cleaning fluid</td>
<td>5L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CON 003</td>
<td>Rinse fluid</td>
<td>5L</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CON 005</td>
<td>Yellow Pipette Tips (5L)</td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CON 006</td>
<td>Blue Pipette Tips (1000L) <b>[FACSCalibur]</b></td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td></tr>

<tr><td>CON 008</td>
<td>CD4 Stabilizer tubes 5ml</td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CON 009</td>
<td>EDTA Microtainer tubes <b>[Paediatric]</b></td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>

<tr><td>CON 010</td>
<td>EDTA Vacutainer tubes 4ml</td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td></tr>

<tr><td>CON 011</td>
<td>Red top/Plain/Silica Vacutainer tubes 4ml</td>
<td>pcs</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td></tr>
					
					';
        $html_data1 .='</tbody></table>';
//$html_data .=$html_data1;
        $report_type = $reportType;
        switch ($report_type) {
            case 'excel':
                $this->generate_fcdrr_Report_excel($report_name, $title, $html_data1);
                break;
            case 'pdf':
                $this->generate_fcdrr_Report_pdf($report_name, $title, $html_data1);
                break;
        }
    }

    public function generate_fcdrr_Report_pdf($report_name, $title, $html_data) {
        $current_year = date('Y');
        $current_month = date('F');
        $facility_code = $this->session->userdata('news');
        $facility_name_array = Facilities::get_facility_name($facility_code)->toArray();
        $facility_name = $facility_name_array['facility_name'];
        //if ($display_type == "Download PDF") {

        /*         * ******************************************setting the report title******************** */

        $html_title = "<div ALIGN=CENTER><img src='" . base_url() . "Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold;'>Division of Reproductive Health Report</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold; '>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>" . $current_month . " " . $current_year . "</h2>
       <hr />   ";


        $css_path = base_url() . 'CSS/style.css';

        /*         * ********************************initializing the report ********************* */
        $this->load->library('mpdf');
        $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
        //$stylesheet = file_get_contents("$css_path");
        //$this->mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
        $this->mpdf->SetTitle($title);
        $this->mpdf->WriteHTML($html_title);
        $this->mpdf->simpleTables = true;
        $this->mpdf->WriteHTML('<br/>');
        $this->mpdf->WriteHTML($html_data);
        $reportname = $report_name . ".pdf";
        $this->mpdf->Output($reportname, 'D');
    }

    public function generate_fcdrr_Report_excel($report_name, $title, $html_data) {
        $data = $html_data;
        $filename = $report_name;
        header("Content-type: application/excel");
        header("Content-Disposition: attachment; filename=$filename.xls");
        echo "$data";
    }

    public function new_counties_alloc() {
        $data['title'] = 'National allocations';
        $data['banner_text'] = 'National allocations';
        $data['content_view'] = 'allocation_committee/allocation_v';
        $this->load->view('template', $data);
    }

    public function new_counties_alloc_chart() {
        echo "<chart caption='Counties Allocation NAtional' xAxisName='Month' yAxisName='Revenue' showValues='0' numberPrefix=''>";
        $counties = counties::getAllcounties();
        foreach ($counties as $counties_data) {
            $counties_data_id = $counties_data["id"];
            $counties_data_name = $counties_data["county"];
//			var_dump($counties_data);
            echo "<categories><category label='$counties_data_name' /></categories>";
        }
// counties are already displaying on graph.. now to diplay the neccesary data
        echo "
 
   <dataset seriesName='Rapid HIV 1+ 2 Test Kit  (Unigold)'>
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />     
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />

   </dataset>

   <dataset seriesName='Rapid HIV 1+2 Test Kit (Determine)'>
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />     
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />
   </dataset>
 <dataset seriesName='Rapid Syphillis Test (RPR)'>
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />     
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='27400' />
      <set value='29800'/>
      <set value='25800' />
      <set value='26800' />
      <set value='29600' />
      <set value='32600' />
      <set value='31800' />
      <set value='36700' />
      <set value='29700' />
      <set value='31900' />
      <set value='34800' />
      <set value='24800' />
   </dataset>
   <trendlines>
      <line startValue='42000' color='91C728' displayValue='Target' showOnTop='1'/>
   </trendlines>

</chart>";
    }

    public function national_allocation() {
        $data['banner_text'] = "National Allocation";
        $data['content_view'] = "allocation_committee/national_allocation_v";
        $data['title'] = "National Allocation";
        $this->load->view('template', $data);
    }

    public function national_allocation_chart() {

        $str_xml_body = '';
//		$title="";
        $strXML = "<chart caption='National Allocation' yAxisName='Allocation' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>";


        $allocations = rtk_stock_status::get_national_allocation();
        $counties = counties::getAllcounties();
        foreach ($counties as $counties_data) {
            $counties_data_id = $counties_data["id"];
        }

        $districts = districts::getDistrict(2); // Gets districts within county id 2
        foreach ($districts as $districts_data) {
            $districts_data_id = $districts_data["id"];
            $districts_data_name = $districts_data["district"];
//		echo $districts_data_id;
//echo $districts_data_name."<br /><br />";
            $facilities = facilities::getFacilities($districts_data_id);
            foreach ($facilities as $facilities_data) {
                $facilities_data_id = $facilities_data["id"];
                $facilities_data_code = $facilities_data["facility_code"];

                $allocations = rtk_stock_status::get_county_allocation($facilities_data_code);
                $sum_determine = 0;
                $sum_unigold = 0;
                $sum_syphillis = 0;
                $commodity = "";


                foreach ($allocations as $allocations_data) {
                    if ($allocations_data["commodity_id"] == 1) {
                        $commodity = "Rapid HIV 1+ 2 Test Kit  (Unigold)";
                        $sum_unigold+=$allocations_data["qty"];
                    }
                    if ($allocations_data["commodity_id"] == 2) {
                        $commodity = "Rapid HIV 1+2 Test Kit (Determine)";
                        $sum_determine+=$allocations_data["qty"];
                    }
                    if ($allocations_data["commodity_id"] == 3) {
                        $commodity = "Rapid Syphillis Test (RPR)";
                        $sum_syphillis+=$allocations_data["qty"];
                    }
                    $allocations_data_commodity_id = $allocations_data["commodity_id"];
                }
            }
            $str_xml_body .="<set value='$sum_determine' label='Total Determine $districts_data_name'/>";
            $str_xml_body .="<set value='$sum_unigold' label='Reporting Unigold $districts_data_name'/>";
            $str_xml_body .="<set value='$sum_syphillis' label='Sum Syphillis $districts_data_name'/>";
        }

        echo $str_xml_body;
        $strXML .="$str_xml_body</chart>";
        echo $strXML;
    }

}

?>