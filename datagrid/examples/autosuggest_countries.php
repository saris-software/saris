<?php

/*
note:
this is just a static test version using a hard-coded countries array.
normally you would be populating the array out of a database

the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/
	$aCountries = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"American Samoa",
		"Andorra",
		"Angola",
		"Anguilla",
		"Antarctica",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Aruba",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bermuda",
		"Bhutan",
		"Bolivia",
		"Bosniaand Herzegowina",
		"Botswana",
		"Bouvet Island",
		"Brazil",
		"British Indian Ocean Territory",
		"British Virgin Islands",
		"Brunei Darussalam",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Cayman Islands",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Christmas Island",
		"Cocos(Keeling) Islands",
		"Colombia",
		"Comoros",
		"Congo",
		"Cook Islands",
		"CostaRica",
		"Cote Divoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Falkland Islands(Malvinas)",
		"Faroe Islands",
		"Fiji",
		"Finland",
		"France",
		"French Guiana",
		"French Polynesia",
		"French Southern Territories",
		"Gabon",
		"Gambia",
		"Georgia",
		"Germany",
		"Ghana",
		"Gibraltar",
		"Greece",
		"Greenland",
		"Grenada",
		"Guadeloupe",
		"Guam",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Heardand McDonald Islands",
		"Honduras",
		"HongKong",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iraq",
		"Ireland",
		"Islamic Republic of Iran",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, Dem.Peoples Rep of",
		"Korea, Republic of",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libyan Arab Jamahiriya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macau",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Martinique",
		"Mauritania",
		"Mauritius",
		"Mayotte",
		"Mexico",
		"Micronesia",
		"Moldova, Republic of",
		"Monaco",
		"Mongolia",
		"Montserrat",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepal",
		"Netherlands",
		"Netherlands Antilles",
		"New Caledonia",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Niue",
		"Norfolk Island",
		"Northern Mariana Islands",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Pitcairn",
		"Poland",
		"Portugal",
		"Puerto Rico",
		"Qatar",
		"Reunion",
		"Romania",
		"Russian Federation",
		"Rwanda",
		"Saint Lucia",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"SouthAfrica",
		"Spain",
		"SriLanka",
		"St.Helena",
		"St.Kittsand Nevis",
		"St.Pierreand Miquelon",
		"St.Vincent and the Grenadines",
		"Sudan",
		"Suriname",
		"Svalbard and Jan Mayen Islands",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syrian Arab Republic",
		"Taiwan",
		"Tajikistan",
		"Tanzania, United Republic of",
		"Thailand",
		"Togo",
		"Tokelau",
		"Tonga",
		"Trinidadand Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Turksand Caicos Islands",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom(Great Britain)",
		"United States",
		"United States Virgin Islands",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City State",
		"Venezuela",
		"Vietnam",
		"Wallis And Futuna Islands",
		"Western Sahara",
		"Yemen",
		"Zaire",
		"Zambia",
		"Zimbabwe"
	);
	
	$aInfo = array();
	
	$input = strtolower( $_GET['input'] );
	$len = strlen($input);
	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
	
	
	$aResults = array();
	$count = 0;
	
	if ($len)
	{
		for ($i=0;$i<count($aCountries);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//
			if (strtolower(substr(utf8_decode($aCountries[$i]),0,$len)) == $input)
			{
				$count++;
				$aResults[] = array( "id"=>($i+1) ,"value"=>htmlspecialchars($aCountries[$i]), "info"=>"" );
			}
			
			if ($limit && $count==$limit)
				break;
		}
	}
	
	
	
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0
	
	
	
	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$aResults[$i]['id']."\", \"value\": \"".$aResults[$i]['value']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<count($aResults);$i++)
		{
                    echo "<rs id=\"".$aResults[$i]['id']."\" info=\"".$aResults[$i]['info']."\">".$aResults[$i]['value']."</rs>";
		}
		echo "</results>";
	}
?>