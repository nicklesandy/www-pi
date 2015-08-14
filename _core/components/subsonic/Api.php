<?php
class Subsonic
{
	protected $_serverUrl;
	protected $_serverPort;
	protected $_creds;
	protected $_commands;
	
	// http://www.subsonic.org/pages/api.jsp 
	
	function __construct($username, $password, $serverUrl, $port="4040", $client="SubPHP")
	{
		$this->setServer($serverUrl, $port);
		$this->_creds = array(
			'u' => $username,
			'p' => $password,
			'v' => '1.12.0', //REST API version (Will need to change if subsonic updates
			'c' => $client, //client name
			'f' => 'json' // tells the subsonic server to respond in json rather than xml
		);
		$this->_commands = array(
			'ping',
			'getLicense',
			'getMusicFolders',
			'getNowPlaying',
			'getIndexes',
			'getMusicDirectory',
			'search',
			'search2',
			'getPlaylists',
			'getPlaylist',
			'createPlaylist',
			'deletePlaylist',
			'download',
			'stream',
			'getCoverArt',
			'scrobble',
			'changePassword',
			'getUser',
			'createUser',
			'deleteUser',
			'getChatMessages',
			'addChatMessage',
			'getAlbumList',
			'getRandomSongs',
			'getLyrics',
			'jukeboxControl',
			'getPordcasts',
			'createShare',
			'updateShare',
			'deleteShare',
			'setRating',
		);
	}
	
	public function querySubsonic($action, $o=array(), $rawAnswer=false)
	{
		return $this->_querySubsonic($action, $o, $rawAnswer);
	}
	
	protected function _querySubsonic($action, $o=array(), $rawAnswer=false)
	{
		if ($this->isCommand($action)) // Make sure the command is in the list of commands
		{
			$params = array_merge($this->_creds, $o);
			$url = $this->getServer() . "/rest/" . $action . ".view?" . http_build_query($params);
			$options = array(
				CURLOPT_URL => $url,
				CURLOPT_HEADER => 0,
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_CONNECTTIMEOUT => 8,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_FOLLOWLOCATION => 1,
				CURLOPT_PORT => intval($this->_serverPort)
			);
			$ch = curl_init();
			curl_setopt_array($ch, $options);
			$answer = curl_exec($ch);
			curl_close($ch);
			
			if($rawAnswer)
			{
				return $answer;
			}
			else
			{
				return $this->parseResponse($answer);
			}
		}
		else
		{
			return $this->error("Error: Invalid subsonic command: " . $action);
		}
	}
	
	public function setServer($server, $port=null)
	{
		$server = preg_replace("/^\w{1,6}\:\/\//", "http://", $server);
		if(!preg_match("/^http\:\/\//", $server))
		{
			$server = "http://". $server;
		}
		
		// If theres a port on the url, remove it and save it for later use.
		preg_match("/\:\d{1,6}$/", $server, $matches);
		if(count($matches))
		{
			$server = str_replace($matches[0], "", $server);
			$_port = str_replace(":", "", $matches[0]);
		}
		
		// If port parameter not set but there was one on the url, use the one from the url.
		if($port == null && isset($_port))
		{
			$port = $_port;
		}
		else if($port == null)
		{
			$port = "4040";
		}
		
		$this->_serverUrl = $server;
		$this->_serverPort = $port;
	}
	
	public function getServer()
	{
		return $this->_serverUrl . ":" . $this->_serverPort;
	}
	
	protected function error($error, $data=null)
	{
		error_log($error ."\n". print_r($data, true));
		return (object) array("success"=>false, "error"=>$error, "data"=>$data);
	}
	
	protected function parseResponse($response)
	{
		$object = json_decode($response);
		$object = is_object($object) ? $object : new stdClass();
		
		if(property_exists($object, "subsonic-response"))
		{
			$response = (array)$object->{'subsonic-response'};
			//$data = array_shift($response);
			$data = $response;
			//if(property_exists($data, "status"))
			//{
				//if($data->status == 'ok')
				//{
					return (object) array("success"=>true, "data"=>$data);
				/*}
				else
				{
					return $this->error("Invalid response from server!", $object);
				}*/
			/*}
			else
			{
				return $this->error("Invalid response from server!", $object);
			}*/
		}
		else
		{
			return $this->error("Invalid response from server!", $object);
		}	
	}
	
	public function isCommand($command)
	{
		return in_array($command, $this->_commands);
	}
	
	public function __call($action, $arguments)
	{
		$o = count($arguments) ? (array) $arguments[0] : array();
		return $this->_querySubsonic($action, $o);
	}
	
	
	// method implementations
	
	public function getPlaylists()
	{
		return $this->_querySubsonic('getPlaylists')->data['playlists']->playlist;
	}
	
	public function getPlaylist($id)
	{
		return $this->_querySubsonic('getPlaylist', array('id' => $id))->data['playlist']->entry;
	}
	
	
	public function getIndexes()
	{
		return $this->_querySubsonic('getIndexes')->data['indexes']->index;
	}
	
	public function getMusicDirectory($id)
	{
		$data = $this->_querySubsonic('getMusicDirectory', array('id' => $id))->data['directory'];
		if(property_exists($data, "child")){
			return $data->child;
		}
		else {
			return []
		}
	}
	
}

?>