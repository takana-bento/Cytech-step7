<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <!-- タイトル -->
        <h1 class="text-2xl font-normal mb-2">ユーザー新規登録画面</h1>

        <form method="POST" action="{{ route('register') }}" class="w-96 space-y-12">
            @csrf

            <!-- Email -->
            <div>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    autofocus 
                    placeholder="アドレス"
                    class="w-full border px-3 py-1" 
                />
                <div class="form__error @if($errors->has('email')) visible @endif">
                    @foreach ($errors->get('email') as $message)
                        {{ $message }}
                    @endforeach
                </div>
            </div>

            <!-- Password -->
            <div>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    placeholder="パスワード"
                    class="w-full border px-3 py-1" 
                />
                <div class="form__error @if($errors->has('password')) visible @endif">
                    @foreach ($errors->get('password') as $message)
                        {{ $message }}
                    @endforeach
                </div>
            </div>

            <!-- ボタン -->
            <div class="flex justify-between mt-6 mx-6">
                <!-- 登録ボタン -->
                <button 
                    type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-black font-normal py-1 px-6 rounded-full"
                >
                    新規登録
                </button>

                <!-- 戻るボタン -->
                <a 
                    href="{{ route('login') }}"
                    class="bg-cyan-400 hover:bg-cyan-500 text-black font-normal py-1 px-10 rounded-full"
                >
                    戻る
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>