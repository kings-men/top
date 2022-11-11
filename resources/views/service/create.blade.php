<x-master-layout>
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">
                <div class="card card-block card-stretch">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h5 class="font-weight-bold">{{ $pageTitle ?? __('messages.list') }}</h5>
                                <a href="{{ route('service.index') }}" class="float-right btn btn-sm btn-primary"><i class="fa fa-angle-double-left"></i> {{ __('messages.back') }}</a>
                            @if($auth_user->can('service list'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($servicedata,['method' => 'POST','route'=>'service.store', 'enctype'=>'multipart/form-data', 'data-toggle'=>"validator" ,'id'=>'service'] ) }}
                            {{ Form::hidden('id') }}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{ Form::label('name',__('messages.name').' <span class="text-danger">*</span>',['class'=>'form-control-label'], false ) }}
                                    {{ Form::text('name',old('name'),['placeholder' => __('messages.name'),'class' =>'form-control','required']) }}
                                    <small class="help-block with-errors text-danger"></small>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    {{ Form::label('order',__('messages.order').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    {{ Form::number('order',null, [ 'min' => 1, 'step' => 'any' , 'placeholder' => __('messages.order'),'class' =>'form-control', 'required' ]) }}
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label class="form-control-label" for="logo">{{ __('messages.logo') }} </label>
                                    <div class="custom-file">
                                        <input type="file" name="logo[]" class="custom-file-input" data-file-error="{{ __('messages.files_not_allowed') }}" >
                                        <label class="custom-file-label">{{  __('messages.choose_file',['file' =>  __('messages.attachments') ]) }}</label>
                                    </div>
                                    <span class="selected_file"></span>
                                </div>

                                <div class="form-group col-md-6">
                                    {{ Form::label('status',__('messages.status').' <span class="text-danger">*</span>',['class'=>'form-control-label'],false) }}
                                    {{ Form::select('status',['1' => __('messages.active') , '0' => __('messages.inactive') ],old('status'),[ 'class' =>'form-control select2js','required']) }}
                                </div>
                            </div>
                                
                                <div class="row service_attachment_div">
                                    <div class="col-md-12">
                                    @if(getMediaFileExit($servicedata, 'service_attachment'))
                                        @php
                                            $attchments = $servicedata->getMedia('service_attachment');
                                            $file_extention = config('constant.IMAGE_EXTENTIONS');
                                        @endphp
                                        <div class="border-left-2">
                                            <p class="ml-2"><b>{{ __('messages.attached_files') }}</b></p>
                                            <div class="ml-2 mt-3">
                                            <div class="row">
                                        @foreach($attchments as $attchment ) 
                                            <?php 
                                                $extention = in_array(strtolower(imageExtention($attchment->getFullUrl())),$file_extention);
                                            ?>
                                            
                                            <div class="col-md-2 pr-10 text-center galary file-gallary-{{$servicedata->id}}"  data-gallery=".file-gallary-{{$servicedata->id}}" id="service_attachment_preview_{{$attchment->id}}">
                                            @if($extention)   
                                                <a id="attachment_files" href="{{ $attchment->getFullUrl() }}" class="list-group-item-action attachment-list" target="_blank">

                                                    <img src="{{ asset('storage/'. $attchment->id .'/'.$attchment->file_name ) }}">

                                                </a>
                                            @else
                                                <a id="attachment_files" class="video list-group-item-action attachment-list" href="{{ $attchment->getFullUrl() }}">
                                                    <img src="{{ asset('images/file.png') }}" class="attachment-file">
                                                </a>
                                            @endif
                                                <a class="text-danger remove-file" href="{{ route('remove.file', ['id' => $attchment->id, 'type' => 'service_attachment']) }}"
                                                    data--submit="confirm_form"
                                                    data--confirmation='true'
                                                    data--ajax="true"
                                                    data-toggle="tooltip"
                                                    title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.attachments") ] ) }}'
                                                    data-title='{{ __("messages.remove_file_title" , ["name" =>  __("messages.attachments") ] ) }}'
                                                    data-message='{{ __("messages.remove_file_msg") }}'>
                                                    <i class="ri-close-circle-line"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                        </div>
                                        </div>
                                        </div>
                                    @endif
                                </div>
                                </div>

                                <div class="row">
                                <div class="form-group col-md-12">
                                    {{ Form::label('description',__('messages.description'), ['class' => 'form-control-label']) }}
                                    {{ Form::textarea('description', null, ['class'=>"form-control textarea" , 'rows'=>3  , 'placeholder'=> __('messages.description') ]) }}
                                </div>
                            
                            </div>
                            {{ Form::submit( __('messages.save'), ['class'=>'btn btn-md btn-primary float-right']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @section('bottom_script')
        <script type="text/javascript">
            (function($) {
                "use strict";
                $(document).ready(function(){
                  

                    providerAddress(provider_id,provider_address_id)
                    getSubCategory(category_id,subcategory_id)

                    $(document).on('change' , '#provider_id' , function (){
                        var provider_id = $(this).val();
                        $('#provider_address_id').empty();
                        providerAddress(provider_id,provider_address_id);
                    })
                    $(document).on('change' , '#category_id' , function (){
                        var category_id = $(this).val();
                        $('#subcategory_id').empty();
                        getSubCategory(category_id,subcategory_id);
                    })

                    $('.galary').each(function (index,value) {
                        let galleryClass = $(value).attr('data-gallery');
                        $(galleryClass).magnificPopup({
                            delegate: 'a#attachment_files',
                            type: 'image',
                            gallery: {
                                enabled: true,
                                navigateByImgClick: true,
                                preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                            },
                            callbacks: {
                                elementParse: function(item) {
                                    if(item.el[0].className.includes('video')) {
                                        item.type = 'iframe',
                                        item.iframe = {
                                            markup: '<div class="mfp-iframe-scaler">'+
                                                    '<div class="mfp-close"></div>'+
                                                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                                                    '<div class="mfp-title">Some caption</div>'+
                                                '</div>'
                                        }
                                    } else {
                                        item.type = 'image',
                                        item.tLoading = 'Loading image #%curr%...',
                                        item.mainClass = 'mfp-img-mobile',
                                        item.image = {
                                            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                                        }
                                    }
                                }
                            }
                        })
                    })
                }) 
           
                
            })(jQuery);
        </script>
    @endsection
</x-master-layout>