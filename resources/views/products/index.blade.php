<x-app-layout>
    <x-slot name="header"></x-slot>
    
    <div class="bg-white min-h-screen py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- ページタイトル -->
            <h2 class="font-normal text-4xl mb-12 text-gray-800 leading-tight">
                商品一覧画面
            </h2>

            <!-- 検索フォーム -->
            <form
                method="GET"
                action="{{ route('products.index') }}" 
                class="mb-12 flex w-full gap-2"
            >

                <!-- 入力欄とセレクトボックスの共通スタイル -->
                @php
                    $formInputClass = 'border border-gray-400 rounded px-3 py-2 h-10 focus:outline-none focus:border-gray-500';
                @endphp

                <!-- キーワード検索 -->
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}" 
                    placeholder="検索キーワード"
                    class="{{ $formInputClass }} flex-1"
                >

                <!-- 会社選択 -->
                <div class="relative flex-1">
                    <select
                        name="company_id"
                        class="{{ $formInputClass }} select-custom w-full border border-gray-400 rounded px-3 py-2 pr-8 appearance-none"
                    >
                        <option value="">会社名</option>
                        @foreach($companies as $company)
                            <option
                                value="{{ $company->id }}" 
                                @selected(request('company_id') == $company->id)
                            >
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- セレクト矢印 -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                        ▽
                    </div>
                </div>

                <!-- 検索ボタン -->
                <button
                    type="submit"
                    class="{{ $formInputClass }} bg-white text-black hover:bg-gray-100"
                >
                    検索
                </button>
            </form>

            <!-- 商品テーブル -->
            <div class="bg-white overflow-hidden">
                <table class="table-fixed text-2xl border-collapse border border-gray-500 w-full text-left">

                    <!-- テーブルヘッダー -->
                    <thead>
                        <tr class="bg-white">
                            <th class="px-5 py-5 w-8 text-center">ID</th>
                            <th class="px-1 py-5 w-24 text-center">商品画像</th>
                            <th class="px-1 py-5 w-16 text-center">商品名</th>
                            <th class="px-1 py-5 w-16 text-center">価格</th>
                            <th class="px-1 py-5 w-16 text-center">在庫数</th>
                            <th class="px-1 py-5 w-24 text-center">メーカー名</th>
                            <th class="px-1 py-5 w-32 text-center">
                                <!-- 新規登録ボタン -->
                                <a 
                                    href="{{ route('products.create') }}"
                                    class="font-normal bg-orange-400 rounded hover:bg-orange-600 text-black text-xl border border-gray-400 px-2 py-1.5 inline-block"
                                >
                                    新規登録
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <!-- テーブルボディ -->
                    <tbody>
                        @foreach($products as $product)
                            <tr class="odd:bg-neutral-300 even:bg-white border-b border-gray-600">

                                <!-- 商品ID -->
                                <td class="px-5 py-5">{{ $product->id }}.</td>

                                <!-- 商品画像 -->
                                <td class="px-1 py-5 text-center">
                                    @if($product->img_path)
                                        <img
                                            src="{{ asset('storage/' . $product->img_path) }}" 
                                            alt="商品画像"
                                            class="w-10 h-10 object-cover mx-auto"
                                        >
                                    @else
                                        <span class="text-black">商品画像</span>
                                    @endif
                                </td>

                                <!-- 商品名 -->
                                <td class="px-1 py-5 product-name-cell">
                                    <span class="product-name-text">{{ $product->product_name }}</span>
                                </td>

                                <!-- 価格 -->
                                <td class="px-1 py-5 text-center whitespace-nowrap">¥{{ number_format($product->price) }}</td>

                                <!-- 在庫数 -->
                                <td class="px-1 py-5 text-center whitespace-nowrap">{{ $product->stock }}</td>

                                <!-- 会社名 -->
                                <td class="px-1 py-5 text-center whitespace-nowrap">{{ $product->company->company_name ?? '-' }}</td>

                                <!-- 詳細・削除アクション -->
                                <td class="px-1 py-5 text-center flex justify-center gap-3">
                                    @php
                                        $showRoute = [
                                            'product' => $product->id,
                                            'page' => request()->get('page', 1)
                                        ];
                                    @endphp
                                    <!-- 詳細ボタン -->
                                    <a
                                        href="{{ route('products.show', $showRoute) }}"
                                        class="font-normal rounded bg-cyan-400 hover:bg-cyan-500 text-black border border-gray-600 px-3 py-0.5"
                                    >
                                        詳細
                                    </a>
                                    <!-- 削除フォーム -->
                                    <form
                                        action="{{ route('products.destroy', $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('本当に削除しますか？');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="page" value="{{ request()->get('page', 1) }}">
                                        <button class="font-normal rounded bg-red-600 hover:bg-red-700 text-white border border-gray-500 px-3 py-0.5">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>               
                </table>
            </div>

            <!-- ページネーション -->
            <div class="mt-6 flex flex-col items-center">
                <div class="flex gap-1 mb-2">
                    <a
                        href="{{ $products->previousPageUrl() ?? '#' }}"
                        class="px-2 py-1 rounded bg-gray-100 hover:bg-gray-200"
                    >
                        ‹
                    </a>
                    @foreach(range(1, $products->lastPage()) as $i)
                        <a
                            href="{{ $products->url($i) }}"
                            class="px-2 py-1 rounded {{ $i==$products->currentPage() ? 'bg-gray-400 text-white' : 'bg-gray-100 hover:bg-gray-200' }}"
                        >
                            {{ $i }}
                        </a>
                    @endforeach
                    <a
                        href="{{ $products->nextPageUrl() ?? '#' }}"
                        class="px-2 py-1 rounded bg-gray-100 hover:bg-gray-200"
                    >
                        ›
                    </a>
                </div>
                <div class="text-sm text-gray-800">
                    全{{ $products->total() }}件中 {{ $products->firstItem() }}〜{{ $products->lastItem() }}件
                </div>
            </div>
        </div>
    </div>
</x-app-layout>