{% if vendors is null %}
<p><strong>Warning:</strong> First fill vendors</p>
<a href="/">Main page</a>
{% else %}
<form method="POST" action="{{model.getId == '' ? '/transport/create' : '/transport/update/'~model.getId }}">
    <input type="hidden" name="id" value="{{model.getId}}">
    <input type="text" name="model" value="{{model.getModel}}" required placeholder="Model"><br>
    <select name="id_vendor">
        {% for item in vendors %}
        <option value="{{item.getId}}" {{item.getId == model.getIdVendor ? ' selected ' : ''}}>{{item.getName}}</option>
        {% endfor %}
    </select><br>
    <input type="number" name="max_speed" value="{{model.getMaxSpeed}}" required placeholder="Max speed" "><br>

    <p>Passport Data</p>
    <input type="number" name="number_wheel" value="{{model.getNumberWheel}}" required placeholder="Number wheel"><br>
    <input type="number" name="manufactured_at" value="{{passport.getManufacturedAt}}" required
           placeholder="Manufactured at"><br>
    <input type="number" name="personal_number" value="{{passport.getPersonalNumber}}" required
           placeholder="Personal number"><br>
    <input type="number" name="price" value="{{passport.getPrice}}" required placeholder="Price"><br>

    <button type="submit">Save</button>
</form>
{% endif %}

