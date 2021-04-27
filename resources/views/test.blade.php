<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <ul>
                    @foreach ($invoices as $invoice)
                        <li>
                            {{ $invoice->id }} - {{ $invoice->name }} - {{ $invoice->items_price_max }}
                        </li>
                    @endforeach
                </ul>
                <nav aria-label="Page navigation example">
                      {{ $invoices->links() }}
                </nav>
                
            </div>
        </div>
    </body>
</html>
