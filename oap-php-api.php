<?php

/**
 * Office Auto Pilot PHP API Wrapper Class
 *
 * Allows access to the Office Auto Pilot API via PHP
 *
 * @package: 	OAP-PHP-API
 * @author: 	Neal Lambert
 * @last_mod: 	by Neal Lambert 04/25/2013
 * @url: 		http://officeautopilot.com/
 * @api_url: 	http://officeautopilot.com/wp-content/uploads/2010/10/API_reference.pdf
 * @see_also: 	http://support.officeautopilot.com/entries/22308086-contacts-api
 */
 
class OAPAPI {
  
	//API CREDENTIALS
	var $Appid		= '';
	var $Key		= '';

	//API URL
	var $host		= 'http://api.moon-ray.com/';

	//SERVICES
	var $contact 	= 'cdata.php';
	var $product	= 'pdata.php';
	var $form		= 'fdata.php';
	
	
	/**
	* Init
	* @desc: Search OAP for data
	* @params:  $app_id, $key 
	*/
	
	function __construct($app_id=FALSE,$key=FALSE)
	{
		if(empty($app_id) OR empty($key))
			throw new Exception("Missing OAP API Appid or Key");
		
		$this->Appid	= $app_id;
		$this->Key		= $key;
	}

	/**
	* Add Contact (contact)
	* @desc: Search OAP for data
	* @params:  $contact (array) array containing the fields, tags, and sequences to add to a new contact record
	* @access:  public
	* @return:  array of the updated client
	*/

	public function add_contact($contact=FALSE)
	{
	
		$data = '<contact>';
		
		//FIELDS
		$data .= '<Group_Tag name="Contact Information">';
		foreach($contact['fields'] as $field_name => $field_data)
		{
			$data .= '<field name="'.$field_name.'">'.$field_data.'</field>';
		}
		$data .= '</Group_Tag>';
		
		//TAGS / SEQUENCES
		$data .= '<Group_Tag name="Sequences and Tags">';
			
			$data .= '<field name="Contact Tags">'.(!empty($contact['tags']) ? '*/*'.implode('*/*',$contact['tags']).'*/*' : '').'</field>';
			$data .= '<field name="Sequences">'.(!empty($contact['sequences']) ? '*/*'.implode('*/*',$contact['sequences']).'*/*' : '').'</field>';
		
		$data .= '</Group_Tag>';

		$data .= '</contact>';
	
		if($service = $this->_service('contact'))
		{
			return $this->_request($service,'add',$data);
		}
		
		return FALSE;
	}
	
	/**
	* Update Contact(s) (contact)
	* @desc: Update contact(s) record(s)
	* @params:  $contact (array) array of multiple contacts to be updated
	* @access:  public
	* @return:  array of updated contacts
	*/

	public function update_contacts($contacts=FALSE)
	{
		$data = '';
		
		foreach($contacts as $contact)
		{
			$data .= '<contact id="'.$contact['id'].'">';
		
			//FIELDS
			$data .= '<Group_Tag name="Contact Information">';
			foreach($contact['fields'] as $field_name => $field_data)
			{
				$data .= '<field name="'.$field_name.'">'.$field_data.'</field>';
			}
			$data .= '</Group_Tag>';
			
			$data .= '</contact>';
		}

		if($service = $this->_service('contact'))
		{
			return $this->_request($service,'update',$data);
		}
		
		
		return FALSE;
	}
	
	/**
	* Delete Contact(s) (contact)
	* @desc: Delete the select contact IDs for OAP
	* @params:  $contact_ids (array)
	* @access:  public
	* @return:  a success or error message
	*/

	public function delete_contacts($contact_ids=FALSE)
	{
		$data = '';
		
		foreach($contact_ids as $contact_id)
		{
			$data .= '<contact_id>'.$contact_id.'</contact_id>';
		}

		if($service = $this->_service('contact'))
		{
			return $this->_request($service,'delete',$data);
		}
		
		
		return FALSE;
	}
  
  
	/**
	* Add Tags (contact)
	* @desc: Add a tag(s) to a contact record.
	* @access:  public
	* @params:  $contacts (array)	= an array containing a contact id(s)
				$tags (array)		= an array containing a list of tags(s)
				$remove (boolean) - When set to TRUE instead removes the tag(s)
	* @return:  (SimpleXMLObject) "result" containing each tag and the success/failure status
	*/

	public function add_tags($contacts=array(),$tags=array(),$remove=FALSE)
	{
		$data = '';
		
		//PREPARE XML TO SEND
		foreach($contacts as $contact_id)
		{
			$data .= "<contact id='".$contact_id."'>
			";
			
			foreach($tags as $tag)
				$data .= '<tag>'.$tag."</tag>";
			
			$data .= "</contact>";
		}

		//SAVE RESULT
		return $this->_request($this->contact,(!$remove ? 'add_tag' : 'remove_tag'),$data);
	}
	
	/**
	* Remove Tags (contact)
	* @desc: Removes a tag(s) from a contact record.
	* @access:  public
	* @params:  $contacts (array)	= an array containing a contact id(s)
				$tags (array)		= an array containing a list of tags(s)
	* @return:  (SimpleXMLObject) "result" containing each tag and the success/failure status
	*/

	public function remove_tags($contacts=array(),$tags=array())
	{
		return $this->add_tags($contacts,$tags,TRUE);
	}
	
	/**
	* Start Sequences (contact)
	* @desc: Starts a sequence(s) for a contact record.
	* @access:  public
	* @params:  $contacts (array) = an array containing a contact id with an array of tags to be added
				e.g. array('1234' => array('Newsletter','New Client'))
				$remove (boolean) - When set to TRUE instead removes the tag(s)
	* @return:  (SimpleXMLObject) "result" containing each updated contact record
	*/

	public function start_sequences($contacts=array(),$sequences=array(),$remove=FALSE)
	{
		$data = '';
		
		//PREPARE XML TO SEND
		foreach($contacts as $contact_id)
		{
			$data .= "<contact id='".$contact_id."'>";
			$data .= "<Group_Tag name='Sequences and Tags'><field name='Tags'></field>";
			
			$data .= "<field name='Sequences'".($remove ? " action='remove'" : '').'>*/*'.implode('*/*',$sequences)."*/*</field>";
			
			$data .= "</Group_Tag>";
			$data .= "</contact>";
		}
		
		//SAVE RESULT
		return $this->_request($this->contact,'update',$data);
	}
	
	/**
	* Stop Sequences (contact)
	* @desc: Stops a sequence(s) for a contact record.
	* @access:  public
	* @params:  $contacts (array) 	= an array containing a contact id(s)
				$sequences (array) 	= an array containing a sequence id(s)
				$remove (boolean) 	- When set to TRUE instead removes the tag(s)
	* @return:  (SimpleXMLObject) "result" containing each updated contact record
	*/
	
	public function stop_sequences($contacts=array(),$sequences=array())
	{
		return $this->start_sequences($contacts,$sequences,TRUE);
	}
	
	/**
	* Search (contact,product,form)
	* @desc: Search OAP for data
	* @params:  $type (string) - contact,product,form; $patterns (array) of search queries
	* @access:  public
	* @return:  array of contacts, or products
	*/

	public function search($type=FALSE,$patterns=FALSE)
	{
	
		$data = '<search>';
		
		foreach($patterns as $pattern)
		{
			$data .= '<equation>';
				$data .= '<field>'.$pattern['field'].'</field>';
				$data .= '<op>'.$pattern['op'].'</op>';
				$data .= '<value>'.$pattern['value'].'</value>';
			$data .= '</equation>';
		}
		
		$data .= '</search>';
	
		
	
		if($service = $this->_service($type))
		{
			return $this->_request($service,'search',$data);
		}
		
		return FALSE;
	}
	
	/**
	* Fetch (contact,product,form)
	* @desc: Allows you to fetch contacts, products, and forms from OAP.
	* @params:  $type (string) - contact,product,form; $data (array)(contact,product) or (string) for (form)
	* @access:  public
	* @return:  array of contacts, or products
	*/

	public function fetch($type=FALSE,$data=FALSE)
	{
		if($service = $this->_service($type))
		{
			$xml = '';
		
			switch($service)
			{
				//CONTACTS
				case 'cdata.php':
					foreach ($data as $contact_id)
					$xml .= '<contact_id>'.$contact_id.'</contact_id>';
					break;
				//PRODUCTS
				case 'pdata.php':
					foreach ($data as $product_id)
					$xml .= '<product_id>'.$product_id.'</product_id>';
					break;
				//FORMS
				case 'fdata.php':
					$xml .= 'id='.$data;
					break;
			}
			
			return $this->_request($service,'fetch', $xml);
		}
		
		return FALSE;
	}
	
	/**
	* Fetch Tags Type (contact)
	* @desc: List of tag names in the account. Recommended to use Pull Tag instead of this function.
	* @access:  public
	* @return:  array of tags
	*/

	public function fetch_tags_type()
	{
		$return = $this->_request($this->contact,'fetch_tag',FALSE);
		
		if(!empty($return->tags))
		{
			$tags = explode('*/*',$return->tags);
	
			return (is_array($tags) ? array_filter($tags) : $tags);
		}
		
		return FALSE;
	}
	
	/**
	* Fetch Sequences Type (contact)
	* @desc: Gets a list of available sequences.
	* @access:  public
	* @return:  array of sequences e.g. [24] =>  'sequence name which has id 24'
	*/

	public function fetch_sequences_type()
	{
		$sequences = FALSE;
		
		//MAKE API REQUEST
		$return = $this->_request($this->contact,'fetch_sequences',FALSE);
		
		//CONVERT TO ARRAY
		if(!empty($return->sequence))
		{
			foreach($return->sequence as $sequence)
				$sequences[(string)$sequence->attributes()->id] = (string)$sequence;
		}
		
		return $sequences;
	}
	
	/**
	* Key Type (contact, product)
	* @desc: The Key Type is used to visually map out all the fields that are used for a contact on your system. The
			 fields are organized in groups.
	* @access:  public
	* @return:  array of tags
	*/

	public function key_type($type=FALSE)
	{
		if($service = $this->_service($type))
		{
			return $this->_request($service,'key','');
		}
		
		return FALSE;
	}
	
	/**
	* Pull Tag (contact)
	* @desc: List of tag names in the account with corresponding ids
	* @access:  public
	* @return:  array of tags
	*/

	public function pull_tag()
	{
		$return = $this->_request($this->contact,'pull_tag',FALSE);
		
		$tags = array();
		
		if(!empty($return->tag))
			foreach($return->tag as $tag)
				$tags[(int)$tag->attributes()->id] = (string)$tag;
		
		return $tags;
	}
	
	/**
	* (Private) Service
	* @desc: Checks to see if the service name is valid and returns the service URL
	* @params: $key (string)
	* @access:  private
	* @return:  object
	*/
	
	private function _service($key)
	{
		switch ($key) 
		{
			case 'contact':
				return $this->contact;
				break;
			case 'contacts':
				return $this->contact;
				break;	
			case 'product':
				return $this->product;
				break;
			case 'products':
				return $this->product;
				break;
			case 'form':
				return $this->form;
				break;
			case 'forms':
				return $this->form;
				break;
			default:
				return FALSE;
				break;
		}
	}
   
	/**
	* (Private) Request
	* @desc: Make a request to the Office Auto Pilot XML Rest API
	* @params: $service (string),$reqType (string), $data_xml (string),$return_id (boolean), $f_add(boolean)
	* @access:  private
	* @return:  object
	*/

	private function _request($service,$reqType,$data=FALSE,$return_id=FALSE,$f_add=FALSE)
	{	
		$postargs = "Appid=".$this->Appid."&Key=".$this->Key."&reqType=".$reqType.($return_id ? '&return_id=1' : '&return_id=1').($data ? '&data='.rawurlencode($data) : '').($f_add ? '&f_add=1' : '');
		
		//print_r($postargs);
		
		$ch = curl_init($this->host.'/'.$service);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postargs);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$output = curl_exec($ch);
		curl_close($ch);
		
		//DEBUG
		//print_r($output);
		//exit();
		
		return (!empty($output) ? new SimpleXMLElement($output) : FALSE );
	}
	
}

/* End of file oap-php-api.php */
/* Location: ./oap-php-api.php */