<?php
	/**
	* OAP PHP API Examples
	* @package OAP-PHP-API
	* @author Neal Lambert
	* @modified by Neal Lambert 01/20/2013
	*/
	
	//Visit: https://www1.moon-ray.com/v2.4/admin.php?action=api
	//to generate your API Appid and Key
	$api_app_id		= 'X_XXXX_XXXXXXXXX';
	$api_key		= 'YYYYYYYYYYYYYYY';
	
	//INCLUDES
	include('oap-php-api.php');
	$oap = new OAPAPI($api_app_id,$api_key);
	
	//echo '<pre>';
	
	/**
	* Get Account Tags Example
	* return: (array) of tags [$tag_id] = $tag_name
	*/
	//var_dump($oap->pull_tag());
	
	/**
	* Get Contacts Example
	* @method: 	fetch
	* @service: contact
	* @data: 	array of contact id's to be fetched.
	*/
	
	/*
	$return = $oap->fetch('contact',array('XXX','YYY'));
	
	
	
	if(!empty($return->contact))
	{
		foreach($return->contact as $record)
		{
			//UNCOMMENT TO VIEW RECORD STRUCTURE
			//print_r($record);
		
		
			//GET THE ELEMENT 'Group_Tag' WITH THE ATTRIBUTE name="Contact Information"
			$contact_info = $record->xpath('Group_Tag[@name="Contact Information"]'); //ALWAYS RETURNS ARRAY
				
				//GET THE ELEMENT 'field' with the attribute name="First Name"
				$first_name = $contact_info[0]->xpath('field[@name="First Name"]');
				
				//GET THE ELEMENT 'field' with the attribute name="Last Name"
				$last_name = $contact_info[0]->xpath('field[@name="Last Name"]');
				
				
			//GET THE ELEMENT 'Group_Tag' WITH THE ATTRIBUTE name="Sequences and Tags"
			$seqs_and_tags = $record->xpath('Group_Tag[@name="Sequences and Tags"]'); //ALWAYS RETURNS ARRAY
			
				//GET THE ELEMENT 'field' with the attribute name="Sequences"
				$sequences 	= $seqs_and_tags[0]->xpath('field[@name="Sequences"]');
				
				//GET THE ELEMENT 'field' with the attribute name="Contact Tags"
				$tags_names = $seqs_and_tags[0]->xpath('field[@name="Contact Tags"]');
				
				//GET THE ELEMENT 'field' with the attribute name="Contact Tags (Raw)"
				$tags_ids	= $seqs_and_tags[0]->xpath('field[@name="Contact Tags (Raw)"]');
			
			
			//OUTPUT DATA
			echo 'Contact ID: '. $record->attributes()->id ."\n";
			echo 'First Name: '. $first_name[0] ."\n";	
			echo 'Last Name: '. $last_name[0] ."\n";	
			echo 'Sequences: '. $sequences[0] ."\n";	
			echo 'Tags (Names): '. $tags_names[0] ."\n";	
			echo 'Tags (Ids): '. $tags_ids[0] ."\n";	
			echo "\n";
		}
	}
	*/
	
	//OTHER EXAMPLES
	//print_r($oap->key_type('product'));
	//print_r($oap->fetch_tags_type());
	//print_r($oap->fetch_sequences_type());
	//$oap->search('contact', array('field' => 'First Name', 'op' => 'c', 'value' => 'K'));
	
	//echo '</pre>';
	
?>