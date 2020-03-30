<?php 

class Scaner {

	public static function scan(string $dir) {
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file = readdir($dh)) !== false) {
		        	if($file != "." AND $file != "..") {
		        		if (is_dir($dir.$file)) {
		        			Scaner::scan($dir.$file."/");
		        		}
		        		if(is_file($dir.$file)) {
			           	 	if(@filetype($dir . $file) === "file" or @filetype($dir . $file) !== "dir") {
			           	 		if (filesize($dir.$file) == 0) {
									echo "Deleting ".$dir.$file." ... ";
									unlink($dir.$file);
									echo "[+] ".date("Y-m-d H:i:s")."\n";
								}
								$ex		= 	explode(".", $file);
								$ex 	= 	end($ex);
								if (in_array($ex, ["mp4", "avi", "mkv", "wmv", "svi", "m4p", "m4v", "webm", "png", "jpg", "jpeg", "gif", "pdf", "word", "wordx", "excel", "wbk", "doc", "dot", "mp4", "avi", "mkv", "wmv", "svi", "m4p", "m4v", "webm", "txt"])) {
									$handle 	= 	fopen($dir.$file, "r");
									$content 	= 	fread($handle, filesize($dir.$file));
									if (strchr($content, "exec") OR strchr($content, "shell_exec") OR strchr($content, "eval") OR substr($content, 0, strlen("<?")) === "<?" OR substr($content, 0, strlen("<?php")) === "<?php" OR substr($content, 0, strlen("<=")) === "<=") {
										echo "Deleting ".$dir.$file." ... ";
										unlink($dir.$file);
										echo "[+] ".date("Y-m-d H:i:s")."\n";
									}else {
										
									}
								}else {
									echo "Deleting ".$dir.$file." ... ";
									@unlink($dir.$file);
									echo "[+] ".date("Y-m-d H:i:s")."\n";
								}
			           	 	}
			           	 }
		           	}
		        }
		        closedir($dh);
		    }
		}
	}

}

while (true) {
	sleep(3);
	Scaner::scan("src/app/views/courses/");
	Scaner::scan("src/app/views/files/");
	sleep(3);
}
