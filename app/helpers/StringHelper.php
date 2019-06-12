<?php

class StringHelper {

	public static function isCleanSlug($slug) {
		$chars = ['Ä','ä','Ö','ö','Ü','ü','ß'];

		foreach($chars as $ch) {
			if(strpos($slug, $ch) > -1) {
				return false;
			}
		}

		return true;
	}
}