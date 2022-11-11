
<?php
    $auth_user= authSession();
?>
{{ Form::open(['route' => ['provider.destroy', $provider->id], 'method' => 'delete','data--submit'=>'provider'.$provider->id]) }}
<div class="d-flex justify-content-end align-items-center">

        @if($auth_user->can('provider edit'))
        <!-- <a class="mr-2" href="{{ route('provider.create',['id' => $provider->id]) }}" title="{{ __('messages.update_form_title',['form' => __('messages.provider') ]) }}"><i class="fas fa-pen text-secondary"></i></a> -->
        @endif
        <a class="mr-2" href="{{ route('provider.show',$provider->id) }}"><i class="far fa-eye text-secondary"></i></a>
        @if($auth_user->can('provider delete'))
       <!--  <a class="mr-2 text-danger" href="javascript:void(0)" data--submit="provider{{$provider->id}}" 
            data--confirmation='true' data-title="{{ __('messages.delete_form_title',['form'=>  __('messages.provider') ]) }}"
            title="{{ __('messages.delete_form_title',['form'=>  __('messages.provider') ]) }}"
            data-message='{{ __("messages.delete_msg") }}'>
            <i class="far fa-trash-alt"></i>
        </a> -->
        @endif
</div>
{{ Form::close() }}