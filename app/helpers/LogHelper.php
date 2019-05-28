<?php

class LogHelper {

	public static function logcms($msg = null) {
		$logf = fopen(storage_path().'/logs/cms.log', 'a+');
		$log = "[".date('Y-m-d H:i:s')."]\nUser: ". (Session::has('user') ? Session::get('user') : 'Unknown') ."\nIP: ". $_SERVER['REMOTE_ADDR'];
		if(isset($msg)) {
			$log .= $msg;
		}

		fwrite($logf, $log ."\n\n");
	}
}