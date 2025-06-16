<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h2>Add Product</h2>
    <form method="POST" action="/add">
        @csrf
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <button type="submit">Add</button>
    </form>


</body>
</html>
