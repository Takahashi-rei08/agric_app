<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <!-- Prefecture -->
        <div>
            <select name='select_prefecture' id='select_prefecture' onchange='changeSlect()'>
                <option value=''>-- 都道府県を選択 --</option>
                @foreach($pref_datas as $pref_data)
                    <option  value='{{ $pref_data["prefCode"] }},{{ $pref_data["prefName"] }}'>{{ $pref_data["prefName"] }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- City -->
        <div>
            <select name='select_city' id='select_city'>
                <option value=''>-- 市区町村を選択 --</option>
            </select>
        </div>
    
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    
    <script>
        function changeSlect(){
            const pref_value = document.getElementById("select_prefecture").value;
            pref_code = pref_value.split(',')[0]
            const pref_data = document.getElementById("select_prefecture")
            alert(pref_data.selectedIndex);
            window.location.href = `/register/${pref_code}`
        }
        
        if(city_datas) {
            // selectタグを取得
            const select_city = document.getElementById("select_city");
            // selectタグの中身を全て削除
            var options = document.querySelectorAll('select_city');
            options.forEach(o => o.remove());
            var option = document.createElement("option");
            option.text = '-- 市区町村を選択 --';
            // optionタグのvalueを設定する
            option.value = '';
            select.appendChild(option);
            
            function addCityOption(citycode, cityname) {
                // selectタグを取得する
                var select = document.getElementById('select_city');
                // optionタグを作成する
                var option = document.createElement("option");
                // optionタグのテキストをprefnameに設定する
                option.text = cityname;
                // optionタグのvalueをprefnameに設定する
                option.value = cityCode+cityname;
                // selectタグの子要素にoptionタグを追加する
                select.appendChild(option);
            }
            
            for (var i = 0; i < pref_datas.length; i++){
                addCityOption(city_data[i]['cityCode'], pref_data[i]['cityName']);
            }
        }
    </script>
</x-guest-layout>