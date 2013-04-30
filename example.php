<?php
	/**
	* OAP PHP API Examples
	* @package OAP-PHP-API
	* @author Neal Lambert
	* @updated by Neal Lambert 04/29/2013
	* @api https://officeautopilot.zendesk.com/forums/20723902-API
	*/
	
	//Visit: https://www1.moon-ray.com/v2.4/admin.php?action=api
	//to generate your API Appid and Key
	$api_app_id		= 'X_XXXX_XXXXXXXXX';
	$api_key		= 'YYYYYYYYYYYYYYY';
	
	//INCLUDES
	include('oap-php-api.php');
	$oap = new OAPAPI($api_app_id,$api_key);
	
	echo '<pre>';
	
	
	/**
	* Search Example
	* return:
	*/
	
	/* 
	  Multiple search queries work as an AND
	  Multiple field values can be separated by a comma
		
	  Available Operators:
		'e' Equal
		'n' Not equal
		's' Starts with
		'c' Like (Ex: Email <op>c</op>@gmail.com will return a search of all the emails that match gmail.com)
		'k' Not Like
		'l'   Less than
		'g' Greater Than
		'm' Less Than or Equal to
		'h' Greater Than or Equal to
	*/
	/*
	//Search for all people whos First Name is (Adam OR Sally OR Mike) AND whos Last Name is not blank
	$query = array( 
		'query1' => array('field' => 'First Name', 'op' => 'c','value' => 'Adam,Sally,Mike'),
		'query2' => array('field' => 'Last Name', 'op' => 'n','value' => '')
	);
	
	$results = $oap->search('contact',$query);
	
	echo 'found: '.count($results->contact).' results';
	
	*/
	
	/**
	* Add Contact Example
	* Only one contact can be sent at a time using this function
	* return: (array) The contact added
	*/
	
	/*
	$contact = array
	(
		'fields' => 
			array
			(
				'First Name' => 'John',
				'Last Name' => 'Galt',
				'E-Mail' => 'john.galt@gmail.com',
				'Home Phone' => '(555) 555-5555',
				'Office Phone' => '(111) 111-1111',
				'Cell Phone' => '(222) 222-2222',
				'Address' => '1234 Unknown St.',
				'Address 2' => 'Suite 54321',
				'City' => 'Atlantis',
				'State' => 'AZ',
				'Zip Code' => '12345',
				'Company' => 'Self Employed'
			),
		'tags' =>
			array
			(
				'Who',
				'Is',
				'JohnGalt',
				'WeAre'
			),
		'sequences' =>
			array
			(
				'1',
				'2'
			)
	);
	
	$results = $oap->add_contact($contact);
	print_r($results);
	
	*/
	
	/**
	* Update Contact(s) Example
	* Update a single or multiple contacts
	* return: (array) The contact(s) updated
	*/
	
	/*
	$contacts = array
	(
		'contact1' => 
			array
			(
			'id' => '1238',
			'fields' => 
				array
				(
					
					'Address' => '1234 Updated St.',
					'Address 2' => 'Suite 12345',
					'City' => 'Atlantis',
					'State' => 'TX',
					'Zip Code' => '84321'
				)
			),
		'contact2' => 
			array
			(
			'id' => '1239',
			'fields' => 
				array
				(
					'E-Mail' => 'new.email@gmail.com',
					'Address' => '1234 New Address LN.',
					'Address 2' => 'Suite 12345',
					'City' => 'Atlantis',
					'State' => 'OK',
					'Zip Code' => '78139'
				)
			)
	);
	
	$results = $oap->update_contacts($contacts);
	print_r($results);

	*/
	
	/**
	* Delete Contact(s) Example
	* Deletes a single or multiple contact records
	* return: a success or error message
	*/
	
	/*
	$contacts__ids_to_delete = array('1238','1239');
	$results = $oap->delete_contacts($contacts__ids_to_delete);
	print_r($results);
	*/
	
	/**
	* Add Tags Example
	* return: (array) of tags [$tag_id] = $tag_name
	*/
	//$contacts = array('123');
	//$tags 	= array('tag1','tag2');
	//print_r($oap->add_tags($contacts,$tags));
	//print_r($oap->remove_tags($contacts,$tags));

	
	/**
	* Get Account Tags Example
	* return: (array) of tags [$tag_id] = $tag_name
	*/
	//var_dump($oap->pull_tag());
	
	
	/**
	* Get Contact(s) Example
	*/
	
	//SINGLE
	//$contacts = array('123');
	//$return = $oap->fetch('contact',$contacts);
	
	//OR MULTIPLE
	//$contacts = array('123','456');
	//$return = $oap->fetch('contact',$contacts);
	
	/*
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
	
	
	/**
	* Get A List of Sequences
	*/
	
	//print_r($oap->fetch_sequences_type());

	
	/**
	* Start/Stop a Sequence
	*/
	
	//SINGLE
	//$sequences = array('1');
	//$contacts  = array('123');
	
	//MULTIPLE
	//$sequences = array('1','2');
	//$contacts  = array('123','456');
	
	//print_r($oap->start_sequences($contacts,$sequences));
	//print_r($oap->stop_sequences($contacts,$sequences));
	
	
	/**
	* Other Examples
	*/
	
	//print_r($oap->key_type('product'));
	//print_r($oap->fetch_tags_type());
	
	echo '</pre>';
	
?>
