<?php

// use Illuminate\Auth\UserTrait;
// use Illuminate\Auth\UserInterface;
// use Illuminate\Auth\Reminders\RemindableTrait;
// use Illuminate\Auth\Reminders\RemindableInterface;

class ExhibitionCluster extends Eloquent { //} implements RemindableInterface {

	// use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'exhibition_clusters';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array(
								// 'password', 'remember_token'
							 );

	public function exhibitions() {
		return $this->belongsToMany('Exhibition', 'exhibition_cluster_exhibition');
	}

	public function tags() {
		return $this->belongsToMany('Tag', 'exhibition_cluster_tag');
	}

}
