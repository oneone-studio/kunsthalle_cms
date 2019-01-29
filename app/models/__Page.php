<?php

class Page extends Eloquent {

	// use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array(
								// 'password', 'remember_token'
							 );

	public function content_section() {
		return $this->belongsTo('ContentSection');
	}

	public function page_sections() {
		return $this->hasMany('PageSection')->orderBy('sort_order');
	}

	public function page_contents() {
		return $this->hasMany('PageContent')->orderBy('sort_order');
	}

	public function page_image_sliders() {
		return $this->hasMany('PageImageSlider')->orderBy('sort_order');
	}
}
