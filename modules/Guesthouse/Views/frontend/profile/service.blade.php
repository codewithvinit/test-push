<?php
if(!$user->hasPermissionTo('guesthouse_create')) return;
$services = \Modules\Guesthouse\Models\Guesthouse::getVendorServicesQuery($user->id)->orderBy('id','desc')->paginate(6);
?>
@if($services->total())
    <div class="bravo-profile-list-services">
        @include('Guesthouse::frontend.blocks.list-guesthouse.index', ['rows'=>$services,'style_list'=>'normal','desc'=>' ','title'=>!empty($view_all) ? __('Guesthouse by :name',['name'=>$user->first_name]) :'','col'=>4])

        <div class="container">
            @if(!empty($view_all))
                <div class="review-pag-wrapper">
                    <div class="bravo-pagination">
                        {{$services->appends(request()->query())->links()}}
                    </div>
                    <div class="review-pag-text text-center">
                        {{ __("Showing :from - :to of :total total",["from"=>$services->firstItem(),"to"=>$services->lastItem(),"total"=>$services->total()]) }}
                    </div>
                </div>
            @else
                <div class="text-center mt30"><a class="btn btn-sm btn-primary" href="{{route('user.profile.services',['id'=>$user->id,'type'=>'guesthouse'])}}">{{__('View all (:total)',['total'=>$services->total()])}}</a></div>
            @endif
        </div>
    </div>
@endif