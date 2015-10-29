<form method="POST" action="{{model.getId == '' ? '/vendor/create' : '/vendor/update/'~model.getId }}">
    <input type="hidden" name="id" value="{{model.getId}}">
    <input type="text" name="name" value="{{model.getName}}" required><br>
    <button type="submit">Save</button>
</form>