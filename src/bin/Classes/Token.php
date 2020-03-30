<?php 

final class Token {

	protected $key 		= "QQAsRRIeoFO6XJbGp2af6MHStHmUsnJA3ME4fjFmyBwlbW18sWUsaUwex3y010FsrOwJtfRLlaZ73pTc+9J03I6DvK4TH3qXSiJvmk1cByJk+WUxZgxmFRElLdSFl2boFv4rffCAFhnyASPI8IzwEhYsfgzJ4uxFP6hXIQhe1xxWhGgE41tzZ4NcoEjgTObEKvLqaJNfZtrkdWJT8sG0gSTDN/0K5HhivQzVb4dsawbWmSB3MgKHCOY7Uq6fRd/7SShVPB/uh5OSEe5zXm/5ICjdOlzYpX4rHa+1Ie8Nxq+lBPs/DE1GUOo5beiXr60Ueh93fLDAIdKEtSy5xdledA==
	";
	protected $iv = "1LR0VkAzqfZjvZV+B7EbEw==";
	protected $data;

	public function ifUserExists(string $userId) {
		$data 			= 	$this->openFile("src/bin/chatRoomsTokens/tokens.json");
		$this->data 	= 	$data;
		if (array_key_exists($userId, $data)) {
			return $data[$userId];
		}else {
			return false;
		}
	}

	final public function verifyToken(string $registredToken, string $cryptedToken) {
		$decryptedToken = $this->decryptToken($cryptedToken);
		return ($decryptedToken == $registredToken) ? true : false;
	}

	final public function openFile(string $file) {
		return json_decode(file_get_contents($file), true);
	}

	final public function decryptToken(string $cryptedToken) {
		return openssl_decrypt($cryptedToken, "aes-256-cbc", $this->key, 0, base64_decode($this->iv));
	}

}