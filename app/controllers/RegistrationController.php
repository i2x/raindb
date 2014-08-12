<?php

use basicAuth\Repo\UserRepositoryInterface;
use basicAuth\formValidation\RegistrationForm;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;

class RegistrationController extends \BaseController {

	/**
	 * @var $user
	 */
	protected $user;

	/**
	 * @var RegistrationForm
	 */
	private $registrationForm;

	function __construct(UserRepositoryInterface $user, RegistrationForm $registrationForm)
	{
		$this->user = $user;
		$this->registrationForm = $registrationForm;
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('registration.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('email', 'password', 'password_confirmation', 'first_name', 'last_name');

		$this->registrationForm->validate($input);

		$input = Input::only('email', 'password', 'first_name', 'last_name');
		$input = array_add($input, 'activated', true);

		$user = $this->user->create($input);
		
		if($user)
		{
			
			$data = array(
					

					'name' => $user->first_name.' '.$user->last_name,

					
					'email' => $user->email,
						
					'password' => input::get('password'),
			
			);
			
			Mail::send('emails.auth.activate', $data, function($message) 
			{
				$message->from('example@rain.com', 'Auth'); // example

				$message->to( input::get('email'), ' ')->subject('Rain - Confirmation of Registration!'); // exsample
			});
			
			
		}

		// Find the group using the group name
    	$usersGroup = Sentry::findGroupByName('Users');

    	// Assign the group to the user
    	$user->addGroup($usersGroup);

		return Redirect::to('login')->withFlashMessage('User Successfully Created!');
	}



}