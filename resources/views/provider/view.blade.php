<x-master-layout>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-block card-stretch">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h5 class="font-weight-bold">{{$pageTitle}}</h5>
                        <a href="{{ route('provider.index') }}   " class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="provider-actions">
                @if($providerdata->status !== 'approved')
                    <a href="{{ route('changeProviderStatus', ['id' => $providerdata->id, 'status' => 'approve' ]) }}" class="badge badge-success" >Approve</a>
                    <a href="{{ route('changeProviderStatus', ['id' => $providerdata->id, 'status' => 'unapprove' ]) }}" class="badge badge-danger" >Unapprove</a>
                @endif
            </div>
        </div>
        <div class="col-lg-8">
            <div class="provider-bottom row card card-block card-stretch">
                        <div class="col-lg-12 card-body p-0">
                             <h5>{{  __('messages.work_experience') }}</h5>
                             <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.experience_years') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->experience_year? (float) $providerdata->experience_years: "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.education') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->education? $providerdata->education : "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.previous_employer') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->previous_employer? $providerdata->previous_employer : "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.referral') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->referral? $providerdata->referral : "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.trade_education') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->trade_education? $providerdata->trade_education : "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.preferred_distance') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->preferred_distance? $providerdata->preferred_distance : "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.trade_organization') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->trade_organization? $providerdata->trade_organization : "-"}}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                     <div class="provider-bottom row card card-block card-stretch">
                        <div class="col-lg-12 card-body p-0">
                            <h5>{{  __('messages.pricing') }}</h5>
                             <table class="table table-borderless mb-0">
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.hourly_rate') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->hourly_rate? (float) $providerdata->hourly_rate: "-"}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <p class="mb-0 text-muted">{{ __('messages.weekend_rate') }}</p>                                        
                                    </td>
                                    <td>
                                        <p class="mb-0 ">{{$providerdata->weekend_rate? $providerdata->weekend_rate: "-"}}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-sm-3 col-lg-12">
                    <div class="card card-block p-card">
                        <div class="profile-box">
                            <div class="profile-card rounded">
                                <img src="{{ getSingleMedia($providerdata->user,'profile_image')  }}" alt="profile-bg" class="avatar-100 d-block mx-auto img-fluid mb-3  avatar-rounded">
                                <h3 class="font-600 text-white text-center mb-5">{{ ucfirst($providerdata->user->first_name) }} {{ucfirst($providerdata->user->last_name) }}
                                </h3>
                            </div>
                            <div class="pro-content rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-icon mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                                        </svg>
                                    </div>
                                    <p class="mb-0 eml">{{$providerdata->user->email}}</p>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-icon mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"></path>
                                        </svg>
                                    </div>
                                    <p class="mb-0">{{$providerdata->contact_number}}</p>
                                </div>
                                @if(!empty($providerdata->address))
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-icon mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="mb-0">
                                        @if($providerdata->states->name || $providerdata->city)
                                            {{ $providerdata->states->name }}, {{ $providerdata->city }}
                                        @endif
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    @if($providerdata->providerPatymentMethod)
        <div class="card row">
            <div class="card-body p-0">
                    <div class="col-lg-12">
                        <div class="provider-bottom row">
                            <div class="col-lg-12">
                                 <h5>{{  __('messages.bank_details') }}</h5>
                                 <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.account_holder_name') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{ $providerdata->providerPatymentMethod->account_holder_name}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.payment_method') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$providerdata->providerPatymentMethod->payment_method}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.account_holder_type') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$providerdata->providerPatymentMethod->account_holder_type}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.last4') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">**** ***** **** {{$providerdata->providerPatymentMethod->last4}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.country_id') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$providerdata->providerPatymentMethod->country->name}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.currency') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$providerdata->providerPatymentMethod->currency}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-0">
                                            <p class="mb-0 text-muted">{{ __('messages.bank_name') }}</p>                                        
                                        </td>
                                        <td>
                                            <p class="mb-0 ">{{$providerdata->providerPatymentMethod->bank_name}}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @endif


    <div class="row">
         <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h5>{{  __('messages.service') }}</h5>
                    </div>
                    {{ $dataTable->table(['class' => 'table  w-100'],false) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row"></div>
</div>
@section('bottom_script')
    {{ $dataTable->scripts() }}
@endsection
</x-master-layout>