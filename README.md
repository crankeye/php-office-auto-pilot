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

- Change the $api_app_id and $api_key to your app_id/key. See Setttings -> Developer Preferences and Resources -> OfficeAutoPilot API Instructions and Key Manager
- Make sure your app_id/key has the correct permissions. 

List of Supported Functions
---------------------------

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