@extends('layouts.app')
 
@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
        @endcomponent
    </div>
    <div class="col-9">
        <div class="container">
            @if ($category !== null)
                <a href="{{ route('products.index') }}">トップ</a> > <a href="#">{{ $major_category->name }}</a> > {{ $category->name }}
                <h1>{{ $category->name }}の商品一覧{{$total_count}}件</h1>
            @elseif ($keyword !== null)
                <a href="{{ route('products.index') }}">トップ</a> > 商品一覧
                <h1>"{{ $keyword }}"の検索結果{{$total_count}}件</h1>
            @endif
        </div>
        <div>
            Sort By
            @sortablelink('id', 'ID')
            @sortablelink('price', 'Price')
        </div>
        <div class="container mt-4">
            <div class="row w-100">
                @foreach($products as $product)
                <div class="col-3">
                    <a href="{{route('products.show', $product)}}">
                        @if ($product->image !== "")
                        <img src="{{ asset($product->image) }}" class="img-thumbnail">
                        @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail">
                        @endif
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <div class="samuraimart-product-label mt-2 mb-3">
                               <p class="my-0">{{$product->name}}</p>

                                <!-- 平均評価 -->
                                <?php
                                    $reviews = $product->reviews()->get();
                                    $score = $reviews->pluck("score")->toArray();
                                    $score_average = 0;
                                    if (count($score) > 0) {
                                        $score_average = array_sum($score) / count($score) ;
                                    }
                                ?>
                                <div class="average my-0">
                                    <div class="average-star">
                                        <p class="average-star-front" style="width: {{round($score_average, 1)*20}}%">★★★★★</p>
                                        <p class="average-star-back">★★★★★</p>
                                    </div>
                                    <div class="average-score">
                                        <p>{{round($score_average, 1)}}</p>
                                    </div>
                                </div>
                                
                                <label class="my-2">￥{{$product->price}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>
@endsection