@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp
<div class="item-news">
    <div class="thumb-image">
        <a href="{{$row->getDetailUrl()}}">
            @if($row->thumbnail_id)
                @if(!empty($disable_lazyload))
                    <img src="{{get_file_url($row->thumbnail_id,'medium')}}" class="img-responsive" alt="{{$translation->name ?? ''}}">
                @else
                    {!! get_image_tag($row->thumbnail_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
                @endif
            @elseif($row->image_id)
                @if(!empty($disable_lazyload))
                    <img src="{{get_file_url($row->image_id,'medium')}}" class="img-responsive" alt="{{$translation->name ?? ''}}">
                @else
                    {!! get_image_tag($row->image_id,'medium',['class'=>'img-responsive','alt'=>$row->title]) !!}
                @endif
            @endif
        </a>
    </div>
    <div class="caption">
        <div class="item-date">
            <ul>
                @php $category = $row->getCategory; @endphp
                @if(!empty($category))
                    @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                    <li>
                        <a href="{{$category->getDetailUrl(app()->getLocale())}}">
                            {{$t->name ?? ''}}
                        </a>
                    </li>
                @endif
                <li class="dot"> {{ display_date($row->updated_at)}}  </li>
            </ul>
        </div>
        <h3 class="item-title"><a style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;" href="{{$row->getDetailUrl()}}"> {{$translation->title}} </a></h3>
        <div class="item-desc">
{{--            {!! get_exceprt($translation->content,70,"...") !!}--}}
            {{ $row->getSeoMeta()['seo_desc'] }}
        </div>
        <div class="item-more">
            <a class="btn-readmore" href="{{$row->getDetailUrl()}}">{{ __('Read More')}}</a>
        </div>
    </div>
</div>
