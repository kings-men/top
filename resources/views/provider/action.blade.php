
<?php
    $auth_user= authSession();
?>
{{ Form::open(['route' => ['provider.destroy', $provider->id], 'method' => 'delete','data--submit'=>'provider'.$provider->id]) }}
<div class="d-flex justify-content-end align-items-center">

        <a class="mr-2" href="{{ route('provider.show',$provider->id) }}"><i class="far fa-eye text-secondary"></i></a>
       
</div>
{{ Form::close() }}