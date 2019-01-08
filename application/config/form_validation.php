<?php

$config = [

	'login/login_user' => [
									[
										'field' => 'email',
										'label' => 'Email address',
										'rules' => 'required|valid_email'
									],
									[
									 	'field' => 'password',
									 	'label' => 'Password',
									 	'rules' => 'required'
									]
					 			],

	'signup/register_user' => [
									[
										'field' => 'email',
										'label' => 'email',
										'rules' => 'required|valid_email|is_unique[users.email]',
										'errors' => ['is_unique'=>'This email is already taken!']
							 	  	],
							 	  	[
								 	  	'field' => 'first_name',
								 	  	'label' => 'First Name',
								 	  	'rules' => 'required|alpha'
							 	 	],
							 	  	[
								 	  	'field' => 'last_name',
								 	  	'label' => 'Last Name',
								 	  	'rules' => 'required|alpha'
							 	  	],
							 	  	[
								 	  	'field' => 'password',
								 	  	'label' => 'Password',
								 	  	'rules' => 'required|min_length[6]|max_length[16]'
									],
									[
										'field' => 'phone_no',
										'label' => 'Phone no',
										'rules' => 'required|numeric|exact_length[10]|is_unique[users.phone_no]',
										'errors' => ['is_unique'=>'This phone no is already registered!']
									]

								],

	'user/update_userdata' => [
									[
										'field' => 'first_name',
										'label' => 'First Name',
										'rules' => 'required|alpha'
									],
									[
										'field' => 'last_name',
										'label' => 'Last Name',
										'rules' => 'required|alpha'
									],
									[
										'field' => 'pincode',
										'label' => 'Pincode',
										'rules' => 'required|exact_length[6]'
									],
									[
										'field' => 'address',
										'label' => 'Address',
										'rules' => 'required|min_length[15]',
										'errors' => ['min_length' => 'Address should be minimun 15 characters long']
									]

								],

	'user/update_password' => [
									[
										'field' => 'current_password',
										'label' => 'current Password',
										'rules' => 'required|min_length[6]|max_length[16]',
										'errors' => ['min_length' => 'Password must be between 6 to 16 characters',
													'max_length' => 'Password must be between 6 to 16 characters'
													]	

									],
									[
										'field' => 'new_password',
										'label' => 'New Password',
										'rules' => 'required|min_length[6]|max_length[16]',
										'errors' => ['min_length' => 'Password must be between 6 to 16 characters',
													'max_length' => 'Password must be between 6 to 16 characters',
													]
									],
									[
										'field' => 'confirm_password',
										'label' => 'Confirm Password',
										'rules' => 'required|min_length[6]|max_length[16]|matches[new_password]',
										'errors' => ['min_length' => 'Password must be between 6 to 16 characters',
													'max_length' => 'Password must be between 6 to 16 characters',
													]
									]
								],

	'submit_ad/upload_ad' => [
									[
										'field' => 'item_name',
										'label' => 'Item name',
										'rules' => 'required'
									],
									[
										'field' => 'category',
										'label' => 'Category',
										'rules' => 'required'
									],
									[
										'field' => 'item_desc',
										'label' => 'Item description',
										'rules' => 'required'
									],
									[
										'field' => 'price',
										'label' => 'Item Price',
										'rules' => 'required|numeric'
									],
									[
										'field' => 'rent_time',
										'label' => 'Rent period',
										'rules' => 'required|numeric'
									],
									[
										'field' => 'userfile[]',
										'label' => 'Item images',
										'rules' => 'callback__image_validation'
									],
									[
										'field' => 'pincode',
										'label' => 'Pincode',
										'rules' => 'required|numeric|exact_length[6]'
									],
									[
										'field' => 'address',
										'label' => 'Address',
										'rules' => 'required|min_length[15]',
										'errors' => ['min_length' => 'Address should be minimun 15 characters long']
									]
								
								]
];