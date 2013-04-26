PHP Office Auto Pilot API Wrapper
=====================

A PHP version of the Office Auto Pilot API.

Installation
------------
Download "oap-php-api.php" and add the following code to your project:

    //INCLUDES
    include('path/to/oap-php-api.php');
    
    $api_app_id		= 'X_XXXX_XXXXXXXXX';
    $api_key		= 'YYYYYYYYYYYYYYY';
    
    $oap = new OAPAPI($api_app_id,$api_key);

- Change the $api_app_id and $api_key to your app_id/key. See "Setttings -> Developer Preferences and Resources -> OfficeAutoPilot API Instructions and Key Manager" or vist: https://www1.moon-ray.com/v2.4/admin.php?action=api
- Make sure your app_id/key has the correct permissions. 

List of Supported Functions
---------------------------

### Add Contact
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
	
	$oap->add_contact($contact);

### Update Contact(s)
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
	
    $oap->update_contacts($contacts);

### Delete Contact(s)
    $contacts_ids_to_delete = array('1238','1239');
    $oap->delete_contacts($contacts_ids_to_delete);
	
### Search
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

### Add Tag(s)
Add tags to a contact record(s)
    $contacts = array('123','456');
    $tags 	= array('tag1','tag2');
    
	$oap->add_tags($contacts,$tags);
	
### Remove Tag(s)
Remove tags from a contact record(s)
    $contacts = array('123','456');
    $tags 	= array('tag1','tag2');
    
	$oap->add_tags($contacts,$tags);
	
### Start Sequence(s)
Add tags to a set of contact records
	
    $sequences = array('1','2');
    $contacts  = array('123','456');
    
    $oap->start_sequences($contacts,$sequences);
	
### Stop Sequence(s)
Add tags to a set of contact records
	
    $sequences = array('1','2');
    $contacts  = array('123','456');
    
    $oap->stop_sequences($contacts,$sequences);

For More Information & Examples
-------------------------------
- View the included "example.php"
- View the API Reference here: http://officeautopilot.com/developers/
- View the Contacts API help article: http://support.officeautopilot.com/entries/22308086-contacts-api