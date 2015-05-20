<?php

if (!defined('INC_PATH')) {
	define ('INC_PATH', realpath(dirname(__FILE__).'/../../').'/');
}

require_once INC_PATH.'pwTools/string/encoding.php';
require_once INC_PATH.'pwTools/tree/Node.php';
require_once INC_PATH.'pwTools/debug/TestingTools.php';

class Token extends Node {
	
	const EOF = '#EOF';
	const DOC = '#DOCUMENT';
	const TXT = '#TEXT';
	
	private $_name = "";
	private $_completeMatch = "";
	private $_beforeMatch = "";
	private $_tokenMatch = "";
	private $_config = null;
	private $_typeExit = false;

	public function __construct($name, $beforeMatch = "", $completeMatch = "", $conf = null) {
		$this->_name = $name;
		$this->_typeExit = (substr($name, 0, 8) == "__exit__");
		if ($this->isExit()) {
			$this->_name = substr($name, 8);
		}
		$this->_beforeMatch = $beforeMatch;
		$this->_completeMatch = $completeMatch;
		$this->_tokenMatch = substr($completeMatch, strlen($beforeMatch));
		$this->_config = $conf;
// 		TestingTools::inform($this->_tokenMatch);
	}
	
	public function __toString() {
		$exit = $this->_typeExit ? "EXIT" : "ENTRY";
		return "[Token: $this->_name: ".pw_s2e_whiteSpace($this->_tokenMatch).", LENGTH={$this->getTextLength()}, $exit]";
	}
	
	public function isExit() {
		return $this->_typeExit;
	}
	
	public function isEntry() {
		return !$this->isExit();
	}
	
	
	public function getTextLength() {
		return strlen($this->_completeMatch);
	}
	
	public function getTokenString() {
		return $this->_tokenMatch;
	}
	
	#public function getTextPosition() {
	#	return $this->_tokenEndCharIndex;
	#}
	
	public function getName() {
		return $this->_name;
	}
	
	public function getTextFull() {
		return $this->_completeMatch;
	}

	public function getTextString() {
		return $this->_beforeMatch;
	}

	public function getConfig() {
		return $this->_config;
	}
	
	public function isEndOfFile() {
		return ($this->_name == self::EOF);
	}

	public function isDocument() {
		return ($this->_name == self::DOC);
	}
	
	public function isText() {
		return ($this->_name == self::TXT);
	}
	
}

?>