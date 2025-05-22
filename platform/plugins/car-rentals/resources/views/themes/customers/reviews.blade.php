@extends(CarRentalsHelper::viewPath('customers.layouts.master'))

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="section-content">
                <div class="table-responsive mb-20">
                    <table class="table table-striped custom-review-table">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 15%">{{ __('Car') }}</th>
                                <th style="width: 15%">{{ __('Image') }}</th>
                                <th>{{ __('Content') }}</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                        @if (count($reviews) > 0)
                            @foreach ($reviews as $review)
                                @php($car = $review->car)
                                <tr class="align-middle">
                                        <td>
                                            <a class="review-information-link" href="{{ $car->url }}" target="_blank">
                                                {{ $car->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ $car->url }}" target="_blank">
                                                <img src="{{ RvMedia::getImageUrl($car->image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $review->car->name }}" width="80">
                                            </a>
                                        </td>
                                    <td>{{ $review->content }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">{{ __('No reviews!') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

                {!! $reviews->links(CarRentalsHelper::viewPath('partials.pagination')) !!}
            </div>
        </div>
    </div>
@stop
