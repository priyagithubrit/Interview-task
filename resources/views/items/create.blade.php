<!DOCTYPE html>
<html>
<head>
    <title>Items Form</title>
    <style>
        .item-group { margin-bottom: 10px; display: flex; align-items: center; }
        .item-group input { margin-right: 10px; }
        .remove-btn, .action-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            margin-left: 5px;
            cursor: pointer;
        }
        .action-btn.edit { background: orange; }
        table { border-collapse: collapse; width: 100%; margin-top: 30px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>{{ isset($item) ? 'Edit Item' : 'Add Items' }}</h1>

    @if (isset($item))
        <form action="{{ route('items.update', $item->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="item-group">
                <input type="text" name="name" value="{{ $item->name }}" required>
                <input type="number" name="quantity" value="{{ $item->quantity }}" required min="1">
                <button type="submit">Update</button>
                <a href="{{ route('items.create') }}" class="action-btn">Cancel</a>
            </div>
        </form>
    @else
        <form id="item-form" action="{{ route('items.store') }}" method="POST">
            @csrf
            <div id="items-wrapper">
                <div class="item-group">
                    <input type="text" name="items[0][name]" placeholder="Item Name" required>
                    <input type="number" name="items[0][quantity]" placeholder="Quantity" required min="1">
                    <button type="button" class="remove-btn" onclick="removeItem(this)">X</button>
                </div>
            </div>

            <button type="button" onclick="addMore()">Add More</button>
            <button type="submit">Save All</button>
        </form>
    @endif

    <script>
        let index = 1;
        function addMore() {
            const wrapper = document.getElementById('items-wrapper');
            const html = `
                <div class="item-group">
                    <input type="text" name="items[${index}][name]" placeholder="Item Name" required>
                    <input type="number" name="items[${index}][quantity]" placeholder="Quantity" required min="1">
                    <button type="button" class="remove-btn" onclick="removeItem(this)">X</button>
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', html);
            index++;
        }

        function removeItem(button) {
            button.parentElement.remove();
        }

        document.getElementById('item-form')?.addEventListener('submit', function () {
            const itemGroups = document.querySelectorAll('.item-group');
            itemGroups.forEach(group => {
                const nameInput = group.querySelector('input[name*="[name]"]');
                const quantityInput = group.querySelector('input[name*="[quantity]"]');
                if (!nameInput.value.trim() || !quantityInput.value.trim()) {
                    group.remove();
                }
            });
        });
    </script>

        <h2>Saved Items</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $key => $itemRow)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $itemRow->name }}</td>
                        <td>{{ $itemRow->quantity }}</td>
                        <td>{{ $itemRow->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('items.edit', $itemRow->id) }}" class="action-btn edit">Edit</a>
                            <form action="{{ route('items.destroy', $itemRow->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="remove-btn" onclick="return confirm('Delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
