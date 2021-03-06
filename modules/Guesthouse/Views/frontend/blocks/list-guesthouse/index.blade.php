<div class="container">
    <div class="bravo-list-hotel layout_{{$style_list}}">
        @if($title)
        <div class="title">
            {{$title}}
        </div>
        @endif
        @if($desc)
            <div class="sub-title">
                {{$desc}}
            </div>
        @endif
        <div class="list-item">
            @if($style_list === "normal")
                <div class="row">
                    @foreach($rows as $row)
                        <div class="col-lg-{{$col ?? 3}} col-md-6">
                            @include('Guesthouse::frontend.layouts.search.loop-grid')
                        </div>
                    @endforeach
                </div>
            @endif
            @if($style_list === "carousel")
                <div class="owl-carousel">
                    @foreach($rows as $row)
                        @include('Guesthouse::frontend.layouts.search.loop-grid')
                    @endforeach
                    @if(count($rows) > 0 && $show_more)
                        @include('Guesthouse::frontend.layouts.search.loop-grid', [
                            'row' => $rows[0],
                            'is_more_item' => true
                        ])
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
