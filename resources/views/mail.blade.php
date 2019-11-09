@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Заказ №{{ $order->id }} Завершен
        @endcomponent
    @endslot

    @slot('subcopy')
        @component('mail::table')
            | Продукт | Колличество | Сумма
            | --- |:---:|:---:|
            @foreach($order->products as $item)
                | <p style="text-align: center">{{ $item->name }}</p> | <p style="text-align: center">{{ $item->pivot->quantity }}</p> | <p style="text-align: center">{{ $item->pivot->quantity * $item->pivot->price }}</p>
            @endforeach
        @endcomponent
        Итого : {{ $totalSum }}
    @endslot

    @slot('footer')
        @component('mail::footer')
            {{ \date('Y') }} © {{ \config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
