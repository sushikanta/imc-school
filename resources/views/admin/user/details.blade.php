<div class="row">
   <div class="col-xl-12">
	  			<div role="tabpanel">
			   <!-- Nav tabs-->
			   <ul class="nav nav-tabs" role="tablist">
				  <li class="nav-item" role="presentation"><a class="nav-link active" href="#personal_tab" aria-controls="personal_tab" role="tab" data-toggle="tab">Personal Detail</a>
				  </li>
				  <li class="nav-item" role="presentation"><a class="nav-link" href="#business_tab" aria-controls="business_tab" role="tab" data-toggle="tab">Business Detail</a>
				  </li>
				  <li class="nav-item" role="presentation"><a class="nav-link" href="#address_tab" aria-controls="address_tab" role="tab" data-toggle="tab">Address Detail</a>
				  </li>
				  <li class="nav-item" role="presentation"><a class="nav-link" href="#card_tab" aria-controls="card_tab" role="tab" data-toggle="tab">Card Detail</a>
				  </li>
				   <li class="nav-item" role="presentation"><a class="nav-link" href="#role_tab" aria-controls="card_tab" role="role_tab" data-toggle="tab">Role Detail</a>
				  </li>
			   </ul>
			   <!-- Tab panes-->
			   <div class="tab-content">
				  <div class="tab-pane active" id="personal_tab" role="tabpanel">
				  
						 <div class="row">
						   <div class="col-xl-12">
									   <table class="table table-striped table-bordered table-hover">
										  <tbody>
											 <tr>
												<td class="table-success">Id</td>
												<td>{{ $user->id }}</td>
												<td class="table-success">Email</td>
												<td>{{ $user->email }}</td>
											 </tr>
											  <tr>
												<td class="table-success">First name</td>
												 <td>{{ ($user->firstname)}}</td>
												
												<td class="table-success">Last name</td>
												 <td>{{ $user->lastname }}</td>
											 </tr>
											 
											  <tr>
												<td class="table-success">Registered Date</td>
												 <td>{{ date("F j, Y, g:i A", strtotime($user->created_at))   }}</td>
												
												<td class="table-success">Modified Date</td>
												  <td>{{ date("F j, Y, g:i A", strtotime($user->updated_at))   }}</td>
											 </tr>
											 
											 <tr>
												<td class="table-success">Registered IP</td>
												<td>{{ $user->registered_ip }}</td>
												
												<td class="table-success">Status</td>
												  <td>{{ ucfirst($user->status) }}</td>
											 </tr>
											 
											 
										  </tbody>
									   </table>
						   </div>
						</div>

				  </div>
				  
				  <div class="tab-pane" id="business_tab" role="tabpanel"> 

						<div class="row">
						   <div class="col-xl-12">
										   <table class="table table-striped table-bordered table-hover">
										  <tbody>
										  
											<tr>
												<td class="table-success">Business Name</td>
												<td>{{ @$business->business_name }}</td>
												<td class="table-success">Category</td>
												<td>{{ @$business->title }}</td>
												
											 </tr>
											 
											  <tr>
												<td  class="table-success">Business Details</td>
												  <td colspan="3">{{ @$business->business_detail }}</td>
											 </tr>
										  
											 <tr>
												<td class="table-success">Registration no</td>
												<td>{{ @$business->regd_no }}</td>
												<td class="table-success">Modified Date</td>
												<td>{{ (@$business->updated_at)?date("F j, Y, g:i A", strtotime(@$business->updated_at)):''   }}</td>
											 </tr>
											 
											  <tr>
												<td class="table-success">Business Status</td>
												 <td>{{ @ucfirst($business->status) }}</td>
												
												<td class="table-success">Average Rating</td>
												  <td>{{ @$business->avg_rating }}</td>
											 </tr>
											 
											 
											 
											 
										  </tbody>
									   </table>
						   </div>
						</div> 


				  </div>
				  <div class="tab-pane" id="address_tab" role="tabpanel">
				  
						<div class="row">
						   <div class="col-xl-12">
									   <table class="table table-striped table-bordered table-hover">
										  <tbody>
										  
											<tr>
												<td class="table-success">Type</td>
												<td class="table-success">Default</td>
												<td class="table-success">Country</td>
												<td class="table-success">State</td>
												<td class="table-success">City</td>
												<td class="table-success">Zip Code</td>
												<td class="table-success">Address Line1</td>
												<td class="table-success">Address Line2</td>
												<td class="table-success">Contact1</td>
												<td class="table-success">Contact2</td>
											 </tr>
											 <tr>
											  @if(count($addresses))
													@foreach($addresses as $addr)
													<td>{{ $addr->type }}</td>
													<td>{{ ($addr->is_default==1)?'Yes':'' }}</td>
													<td>{{ $addr->title }}</td>
													<td>{{ $addr->state }}</td>
													<td>{{ $addr->city }}</td>
													<td>{{ $addr->zipcode }}</td>
													<td>{{ $addr->address1 }}</td>
													<td>{{ $addr->address2 }}</td>
													<td>{{ $addr->contact1 }}</td>
													<td>{{ $addr->contact2 }}</td>
													@endforeach
												@endif
											 </tr>
											 
										  </tbody>
									   </table>
						   </div>
						</div>   

				  
				  </div>
				  <div class="tab-pane" id="card_tab" role="tabpanel">
				  
					<div class="row">
					   <div class="col-xl-12">
						   <table class="table table-striped table-bordered table-hover">
									  <tbody>
										<tr>
											<td class="table-success">Is Default</td>
											<td class="table-success">Card Number</td>
											<td class="table-success">Card Holder Name</td>
											<td class="table-success">CVC</td>
											<td class="table-success">Expiration</td>
											<td class="table-success">Update Date</td>
										 </tr>

										  @if(count($card))
												@foreach($card as $card_data)
											<tr>
												<td>{{ ($card_data->is_default==1)?'Yes':'' }}</td>
												<td>{{ $card_data->card_number }}</td>
												<td>{{ $card_data->card_holder_name }}</td>
												<td>{{ $card_data->cvc }}</td>
												<td>{{ $card_data->expiration_month }}/{{ $card_data->expiration_year }}</td>
												<td>{{ (@$business->updated_at)?date("F j, Y, g:i A", strtotime(@$business->updated_at)):''   }}</td>
											</tr>
												@endforeach
											@endif
									  </tbody>
						   </table>
					   </div>
					</div> 
				  
				  
				  </div>
				  <div class="tab-pane" id="role_tab" role="tabpanel">
				  
						<div class="row">
						   <div class="col-xl-12">
										<table class="table table-striped table-bordered table-hover">
										  <tbody>
											<tr>
											<th> Role Name </th>
											</tr>
											 <tr>
											  @if(count($role))
													@foreach($role as $rl)
													<td>{{ $rl->title }}</td>
													@endforeach
												@endif
											 </tr>
											  
										  </tbody>
									   </table>
						   </div>
						</div>
				  
				  </div>
			   </div>
			</div>
   </div>
</div>

