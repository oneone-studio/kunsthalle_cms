<?php

class MembersController extends BaseController {

    var $states = [];

	public function __construct() {
		$states = [ 'Baden-Württemberg', 'Bavaria', 'Berlin', 'Brandenburg', 'Bremen', 'Hamburg', 'Hesse', 'Lower Saxony', 'Mecklenburg-Vorpommern', 
				'North Rhine-Westphalia', 'Rhineland-Palatinate', 'Saarland', 'Saxony', 'Saxony-Anhalt', 'Schleswig-Holstein', 'Thuringia' ];
		$this->states = $states;
	}

	public function index()

	{
		$members = Member::all()->sortBy('second_name');			
		// echo count($members) . '<br><br>'.'<pre>' . print_r($members); exit;

		return View::make('pages.members.index', ['members' => $members]);
	}

	public function main($id)
	{
		$member = Member::with(['projects'])->find($id);
		// echo '<pre>'; print_r($member); exit;

		return View::make('pages.members.main', [ 'member' => $member]);
	}

	public function create()
	{
		// $members_projects = MemberProject::all(); 

		return View::make('pages.members.create', ['states' => $this->states]);
	}

	public function store()
	{
		$input = Input::all();
		// echo '<pre>'; print_r($input); exit;
		$member = new Member();
		$member->second_name = Input::get('second_name');
		$member->first_name  = Input::get('first_name');
		$member->company = Input::get('company');
		$member->academic_title = Input::get('academic_title');
		$member->professional_title = Input::get('professional_title');
		$member->member_type = Input::get('member_type');
		$member->status = (Input::has('status') && Input::get('status')=='on') ? 1 : 0;
		$member->save();

		return Redirect::action('MembersController@index');
	}	

	public function edit($id)
	{
		$member = Member::with(['projects'])->find($id);
		// echo '<pre>'; print_r($member); exit;
		$member = Member::with(['projects'])->find($id);

		return View::make('pages.members.edit', [ 'member' => $member, 'states' => $this->states]);
	}

	public function update()
	{
		$input = Input::all();
		// echo '<pre>'; print_r($input); exit; 
		/* 
		   Update means we want to save changes for an existing record so 
		   first thing here is to find the desired record i.e., use id from edit page..
		*/
		if(Input::has('id')) { // Only proceed if input includes an id
			$member = Member::with(['projects'])->find(Input::get('id'));   

			$member->second_name = Input::get('second_name');
			$member->first_name = Input::get('first_name');
			$member->company = Input::get('company');
			$member->member_type = Input::get('member_type');
			$member->academic_title = Input::get('academic_title');
			$member->professional_title = Input::get('professional_title');
			// $member->status = (Input::has('status') && Input::get('status')=='on') ? 1 : 0;
			$member->sort_order = Input::get('sort_order');
			$member->save();
		}

		return Redirect::action('MembersController@index');
	}

	// A function used via AJAX .. should return JSON response
	public function updateProfileStatus() {
		if(Request::ajax()) {
			if(Input::has('status')) {
				$member = Member::find(Input::get('id'));
				$member->status = Input::get('status');

				return Response::json(array('error' => false, 'member' => $member), 200); // Success message..
			}
		}

		// Notice the last argument indicates error type.. check the list of standard HTTP error codes
		return Response::json(array('error' => true, 'message' => 'Error updating member'), 422);
	}



	public function destroy($id) {
		Member::where('id', '=', $id)->delete();

		return Redirect::action('MembersController@index');
	}
}