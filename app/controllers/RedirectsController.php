<?php

class RedirectsController extends BaseController {

	public function index()
	{
		$redirects = UrlRedirect::all();
		// echo '<pre>'; print_r($redirects); exit;

		return View::make('pages.redirects.index', ['redirects' => $redirects]);
	}

	public function create() {
		return View::make('pages.redirects.create');
	}

	public function edit($id) {
		$red = UrlRedirect::find($id);

		return View::make('pages.redirects.edit', ['redirect' => $red]);
	}

	public function delete($id) {
		if(is_numeric($id)) {
			UrlRedirect::where('id', $id)->delete();
		}
		
		return Redirect::action('RedirectsController@index');
	}

	public function save() {
		if(Input::has('id')) {
			$red = UrlRedirect::find(Input::get('id'));
			$red->slug = Input::get('slug');
			$red->redirect_url = Input::get('redirect_url');
			$red->save();
		} else {
			$red = new UrlRedirect();
			$red->slug = Input::get('slug');
			$red->redirect_url = Input::get('redirect_url');
			$red->save();
		}

		return Redirect::action('RedirectsController@index');
	}
}
