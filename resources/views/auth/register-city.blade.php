<x-guest-layout>
    <form method="POST" action="{{ route('registerCity') }}">
        <!-- city -->
        <div>
            <select name='select_city' id='select_city' onchange='can_click_btn()' required>
                <option disabled selected value=''>-- 市区町村を選択 --</option>
                @foreach($city_datas as $city_data)
                    <option  value='{{ $city_data["cityCode"] }},{{ $city_data["cityName"] }}'>{{ $city_data["cityName"] }}</option>
                @endforeach
                @method('PUT')
            </select>
        </div>
        <x-primary-button class="ms-4" id='register-city-button' disabled>
            {{ __('Register') }}
        </x-primary-button>
    </form>
    <script>
        function can_click_btn(){
            const button = document.getElementById('register-city-button');
            button.disabled = null;
        };
    </script>
</x-guest-layout>