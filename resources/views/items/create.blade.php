<!DOCTYPE html>
<html>
<head>
    <title>Add Multiple Items</title>
    <style>
        .item-group { margin-bottom: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 30px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Add Items</h1>

    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <div id="items-wrapper">
            <div class="item-group">
                <input type="text" name="items[0][name]" placeholder="Item Name" required>
                <input type="number" name="items[0][quantity]" placeholder="Quantity" required min="1">
                <button type="button" onclick="addMore()">Add More</button>

            </div>
        </div>

        <button type="submit">Save</button>
    </form>

    <script>
        let index = 1;
        function addMore() {
            const wrapper = document.getElementById('items-wrapper');
            const html = `
                <div class="item-group">
                    <input type="text" name="items[${index}][name]" placeholder="Item Name" required>
                    <input type="number" name="items[${index}][quantity]" placeholder="Quantity" required min="1">
                </div>
            `;
            wrapper.insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>

        <h2>Saved Items</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->created_at->format('d-m-y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
