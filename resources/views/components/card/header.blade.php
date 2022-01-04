<div {{ $attributes->merge(['class' => 'card-header p-4'])}} style="background:{{\App\Classes\Color::randomColor()}};">
    <h4 class="text-center" style="font-size: 2.1vw">{{ $slot }}</h4>
</div>