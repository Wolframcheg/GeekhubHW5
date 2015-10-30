{% if vendors is null %}
<p><strong>Warning:</strong> First fill vendors</p>
<a href="/">Main page</a>
{% else %}
<form method="POST" action="{{model.getId == '' ? '/transport/create' : '/transport/update/'~model.getId }}">
    <input type="hidden" name="id" value="{{model.getId}}">
    <label for="model">Model </label><input type="text" name="model" value="{{model.getModel}}" required><br>
    <label for="id_vendor">Vendor(many-to-one) </label><select name="id_vendor">
        {% for item in vendors %}
        <option value="{{item.getId}}" {{item.getId == model.getIdVendor ? ' selected ' : ''}}>{{item.getName}}</option>
        {% endfor %}
    </select><br>
    <label for="max_speed">Max speed </label><input type="number" name="max_speed" value="{{model.getMaxSpeed}}"
                                                    required><br>

    <p>Passport Data(one-to-one)</p>
    <label for="number_wheel">Number wheel </label><input type="number" name="number_wheel"
                                                          value="{{model.getNumberWheel}}" required><br>
    <label for="manufactured_at">Manufactured at </label><input type="number" name="manufactured_at"
                                                                value="{{passport.getManufacturedAt}}" required><br>
    <label for="personal_number">Personal numbe </label><input type="number" name="personal_number"
                                                               value="{{passport.getPersonalNumber}}" required><br>
    <label for="price">Price </label><input type="number" name="price" value="{{passport.getPrice}}" required><br>

    <button type="submit">Save</button>
</form>
{% endif %}

