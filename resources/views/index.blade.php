<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>
            img{width: 100px}
            th{background: #e2e8f0;padding: 10px}
            td{padding: 10px}
        </style>
    </head>
    <body>
        @if($products->isNotEmpty())
            <table>
                <tr>
                    <th>Имя</th>
                    <th>Картинка</th>
                    <th>Цена</th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td><img src="{{$product->image}}" alt=""></td>
                        <td>{{$product->price}}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <h3>Товаров нет</h3>
        @endif
    </body>
</html>
