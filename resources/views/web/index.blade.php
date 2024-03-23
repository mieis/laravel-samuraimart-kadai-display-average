@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-2">
        @component('components.sidebar', ['categories' => $categories, 'major_categories' => $major_categories])
        @endcomponent
    </div>
    <div class="col-9">
        <h1>おすすめ商品</h1>
        <div class="row">
            @foreach ($recommend_products as $recommend_product)
            <div class="col-4">
                <a href="{{ route('products.show', $recommend_product) }}">
                    @if ($recommend_product->image !== "")
                    <img src="{{ asset($recommend_product->image) }}" class="img-thumbnail">
                    @else
                    <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail">
                    @endif
                </a>
                <div class="row">
                    <div class="col-12">
                        <div class="samuraimart-product-label mt-2 mb-3">
                            <p class="my-0">{{ $recommend_product->name }}</p> 

                            <!-- 平均評価 -->
                            <?php
                                $reviews = $recommend_product->reviews()->get();
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
                            <label class="my-2">￥{{ $recommend_product->price }}</label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between">
            <h1>新着商品</h1>
            <a href="{{ route('products.index', ['sort' => 'id', 'direction' => 'desc']) }}">もっと見る</a>
        </div>
        <div class="row">
            @foreach ($recently_products as $recently_product)
                <div class="col-3">
                    <a href="{{ route('products.show', $recently_product) }}">
                        @if ($recently_product->image !== "")
                            <img src="{{ asset($recently_product->image) }}" class="img-thumbnail">
                        @else
                            <img src="{{ asset('img/dummy.png')}}" class="img-thumbnail">
                        @endif
                    </a>
                    <div class="row">
                        <div class="col-12">
                            <div class="samuraimart-product-label mt-2 mb-3">
                                <p class="my-0">{{ $recently_product->name }}</p>

                                <!-- 平均評価 -->
                                <?php
                                    $reviews = $recently_product->reviews()->get();
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
                                
                                <label class="my-2">￥{{ $recently_product->price }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection