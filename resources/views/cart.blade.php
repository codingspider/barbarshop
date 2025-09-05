<table class="cart-table">
    @foreach($items as $item)
    <tr>
        <td>{{ $item->name }}</td>
    </tr>

    @endforeach
</table>