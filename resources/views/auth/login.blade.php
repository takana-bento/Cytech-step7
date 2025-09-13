<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <!-- タイトル -->
        <h1 class="text-2xl font-normal mb-6">ユーザーログイン画面</h1>

        <form method="POST" action="{{ route('login') }}" class="w-96 space-y-12">
            @csrf

            <!-- Email -->
            <div>
                <input 
                    id="email" 
                    type="text" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    placeholder="アドレス"
                    class="w-full border px-3 py-1" 
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    required 
                    placeholder="パスワード"
                    class="w-full border px-3 py-1" 
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- ボタン -->
            <div class="flex justify-between mt-6 mx-6">
                <a 
                    href="{{ route('register') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-black font-normal py-1 px-6 rounded-full"
                >
                    新規登録
                </a>
                <button 
                    type="submit"
                    class="bg-cyan-400 hover:bg-cyan-500 text-black font-normal py-1 px-6 rounded-full"
                >
                    ログイン
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>