<?PHP

// The function is basically for converting the array to object
$facil_mfl = 11555;
function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}
$url = 'http://nascop.org/cd4/arraytest.php?mfl='.$facil_mfl.''; // url for the aPI
$string_manual = file_get_contents($url); // Fetchin the API json
//echo $string_manual;
$string_manual = substr($string_manual, 0, -1); // Removes the last string character ']' from the json
//echo $string_manual;
$string_manual = substr($string_manual, 12); // removes the first 12 string characters which includes a '<pre>' tag up to the '['
//echo $string_manual;
$string = $string_manual;
//$string .= '[{"mfl":"11555","facility":"Malindi District Hospital","device":{"0":"BD Facs Calibur","devices":[{"name":"Tri-TEST CD3\/CD4\/CD45 with TruCOUNT Tubes","code":"CAL 002","unit":"50T Pack","reagentID":"1","report":{"used":"8","received":"60","requested":"70","endbal":"36"}},{"name":"Calibrite 3 Beads","code":"CAL 003","unit":"3 Vials Pack","reagentID":"2","report":{"used":"0","received":"3","requested":"1","endbal":"2"}},{"name":"FACS Lysing solution","code":"CAL 005","unit":"100mL Pack","reagentID":"3","report":{"used":"1","received":"2","requested":"1","endbal":"2"}},{"name":"FACS Clean solution","code":"","unit":"5L Pack","reagentID":"4","report":{"used":"0","received":"0","requested":"5","endbal":"0"}},{"name":"FACS Rinse solution","code":"","unit":"5L Pack","reagentID":"5","report":{"used":"0","received":"1","requested":"5","endbal":"0"}},{"name":"FACS Flow solution","code":"","unit":"20L Pack","reagentID":"6","report":{"used":"1","received":"6","requested":"1","endbal":"7"}},{"name":"Falcon Tubes","code":"CAL 006","unit":"125 pcs Pack","reagentID":"7","report":{"used":"2","received":"0","requested":"1","endbal":"5"}},{"name":"BD Multi-Check Control","code":"","unit":"Pack","reagentID":"8","report":{"used":"0","received":"1","requested":"1","endbal":"0"}},{"name":"BD Multi-Check CD4 Low Control","code":"","unit":"Pack","reagentID":"9","report":{"used":"0","received":"1","requested":"1","endbal":"0"}},{"name":"Printing Paper (A4)","code":"CAL 009","unit":"Raem","reagentID":"10","report":{"used":"2","received":"0","requested":"3","endbal":"0"}},{"name":"HP Laser Jet Printer Catridge 53A","code":"CAL 010","unit":"pcs","reagentID":"11","report":{"used":"1","received":"0","requested":"2","endbal":"1"}},{"name":"Vacutainer EDTA 4ml tubes","code":"CON 007","unit":"100\/pack","reagentID":"27","report":{"used":"4","received":"0","requested":"10","endbal":"0"}},{"name":"Vacutainer Needle 21G [Adult]\r\n","code":"CON 011","unit":"100\/pack","reagentID":"28","report":{"used":"9","received":"0","requested":"20","endbal":"0"}},{"name":"Micortainer tubes [Paediatric]","code":"CON 009","unit":"50\/Pack","reagentID":"30","report":{"used":"1","received":"0","requested":"2","endbal":"0"}},{"name":"Microtainer Pink lancets 21G [Paediatric]","code":"CON 010","unit":"200\/Pack","reagentID":"31","report":{"used":"0","received":"0","requested":"2","endbal":"0"}},{"name":"Vacutainer Butterfly Needle 23G [Paediatrics]","code":"CON 012","unit":"50\/Pack","reagentID":"32","report":{"used":"0","received":"0","requested":"2","endbal":"0"}},{"name":"Yellow Pipette Tips (50 MicroL)","code":"CON 005","unit":"1,000 tips","reagentID":"33","report":{"used":"450","received":"0","requested":"3000","endbal":"2000"}},{"name":"CD4 Stabilizer tubes 5ml","code":"CON 008","unit":"100\/Pack","reagentID":"34","report":{"used":"0","received":"0","requested":"2","endbal":"0"}}]}}]';
//$string .= ' ';
//$string = $string_manual;
//echo $string_manual.'<br /><br />';
//echo $string_manual;


$string_manual = json_decode($string_manual); // decoding the json
$string_manual = objectToArray($string_manual); // This is where I convert String Manual to array
//var_dump($string_manual);

//echo'<br /><br />';
 if ($string_manual==null){
 	 
 }
 else{
 	echo $string_manual['facility'].' ('.$string_manual['mfl'].')<br /> '; 
	echo 'Device : '.$string_manual['device'][0];

	echo "<table border='0' class='data-table' style='font-size: 0.9em;'>"; // Table begins
	echo "<thead><th>Name(Unit)</th><th>reagentID</th><th>received </th><th>used</th><th>requested</th><th>Allocated</th></thead>";
	foreach ($string_manual['device']['devices'] as $reagents_arr) {
	echo "<tr>";
	echo "<td>".$reagents_arr['name'].'('.$reagents_arr['unit'].') </td>';
	echo "<td>".$reagents_arr['reagentID'].' </td>';

	echo "<td>".$reagents_arr['report']['received'].' </td>';
	echo "<td>".$reagents_arr['report']['used'].' ';
	echo "<td>".$reagents_arr['report']['requested'].' </td>';
	echo "<td><input name='reagent' type='text' /></td>";
	echo "</tr />";
	//echo "<pre>";
	//var_dump($reagents_arr);
	//	echo "</pre>";
}
echo "</table>";// end og table
echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
 }
	



?>