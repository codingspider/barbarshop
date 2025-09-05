@foreach($items as $item)
<tr>
    <td>{{ $item->name }}</td>
    <td>
        <button class="btn-remove-cart" data-rowid="{{ $item->rowId }}">Remove</button>
    </td>
</tr>
@endforeach
