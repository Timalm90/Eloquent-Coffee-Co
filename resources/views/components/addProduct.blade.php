<form method="POST" action="{{ route('products.update', $product) }}">
  @csrf
  @method('PATCH')
  <label for="quantity">Lägg till antal</label>
  <input id="quantity" name="quantity" type="number" min="1" required>
  <button type="submit">Lägg till</button>
</form>