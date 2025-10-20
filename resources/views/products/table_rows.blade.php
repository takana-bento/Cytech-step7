@foreach($products as $product)
<tr class="odd:bg-neutral-300 even:bg-white border-b border-gray-600">

    <!-- 商品ID -->
    <td class="px-5 py-5 text-center">{{ $product->id }}.</td>

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
    <td class="px-1 py-5 text-center product-name-cell">
        <span class="product-name-text">{{ $product->product_name }}</span>
    </td>

    <!-- 価格 -->
    <td class="px-1 py-5 text-center whitespace-nowrap">¥{{ number_format($product->price) }}</td>

    <!-- 在庫数 -->
    <td class="px-1 py-5 text-center whitespace-nowrap">{{ $product->stock }}</td>

    <!-- メーカー名 -->
    <td class="px-1 py-5 text-center company-name-cell">
        <span class="company-name-text">{{ $product->company->company_name ?? '-' }}</span>
    </td>

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
        <a
            href="{{ route('products.destroy', $product->id) }}"
            class="delete-btn font-normal rounded bg-red-600 hover:bg-red-700 text-white border border-gray-500 px-3 py-0.5"
        >
            削除
        </a>
    </td>
</tr>
@endforeach