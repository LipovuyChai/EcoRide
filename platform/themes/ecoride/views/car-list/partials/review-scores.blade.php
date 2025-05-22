<span class="text-sm-medium">
    @for($i = 0; $i < $score; $i++)
        <img src="{{Theme::asset()->url("images/icons/star-yellow.svg")}}" alt="EcoRide" />
    @endfor

    @for($i = 0; $i < 5 - $score; $i++)
        <img src="{{Theme::asset()->url("images/icons/star-grey.svg")}}" alt="EcoRide" />
    @endfor
</span>

