<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            メーカー管理（管理者用）
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-md rounded">
        {{-- 成功メッセージ --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- エラーメッセージ --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 会社一覧 --}}
        <table class="w-full border-collapse mb-6">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">登録メーカー一覧</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td class="border px-4 py-2">{{ $company->company_name }}</td>
                        <td class="border px-4 py-2 text-center">
                            <form action="{{ route('admin.companies.destroy', $company->id) }}" method="POST"
                                onsubmit="return confirm('本当に削除しますか？')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    削除
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- 新規追加フォーム --}}
        <form action="{{ route('admin.companies.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="company_name" class="block mb-1 font-medium">メーカー名</label>
                <input
                    type="text" name="company_name" id="company_name"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    placeholder="サントリー" required>
            </div>

            <button type="submit"
                    class="bg-orange-500 text-black px-4 py-2 rounded hover:bg-gray-500">
                追加
            </button>
        </form>
    </div>
</x-app-layout>